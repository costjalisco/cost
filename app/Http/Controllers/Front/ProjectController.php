<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use stdClass;

class ProjectController extends Controller
{
    public function list_projects(Request $request)
    {



        if (empty($request->municipio)) {
            $projects = DB::table('project')
                // ->join('projects_imgs','project.id','=','projects_imgs.id_project')
                ->join('projectsector', 'project.sector', '=', 'projectsector.id')
                ->join('project_locations', 'project.id', '=', 'project_locations.id_project')
                ->join('locations', 'project_locations.id_location', '=', 'locations.id')
                ->join('address', 'locations.id_address', '=', 'address.id')
                ->select('project.*')
                // ->where('address.locality','=',$request->municipio)
                ->get();
            // $projects = DB::table('project')->orderBy('created_at', 'desc')->get();
        } else {
            if (empty($request->id_sector)) {
                $projects = DB::table('project')
                    // ->join('proyecto_contratacion','project.id','=','proyecto_contratacion.id_project')
                    // ->join('projects_imgs','project.id','=','projects_imgs.id_project')
                    ->join('projectsector', 'project.sector', '=', 'projectsector.id')
                    ->join('project_locations', 'project.id', '=', 'project_locations.id_project')
                    ->join('locations', 'project_locations.id_location', '=', 'locations.id')
                    ->join('address', 'locations.id_address', '=', 'address.id')
                    ->select('project.*')
                    ->where('address.locality', '=', $request->municipio)
                    ->get();
            } else {
                if (empty($request->id_subsector)) {
                    $projects = DB::table('project')
                        // ->join('proyecto_contratacion','project.id','=','proyecto_contratacion.id_project')
                        // ->join('projects_imgs','project.id','=','projects_imgs.id_project')
                        ->join('projectsector', 'project.sector', '=', 'projectsector.id')
                        ->join('project_locations', 'project.id', '=', 'project_locations.id_project')
                        ->join('locations', 'project_locations.id_location', '=', 'locations.id')
                        ->join('address', 'locations.id_address', '=', 'address.id')
                        ->select('project.*')
                        ->where('address.locality', '=', $request->municipio)
                        ->where('project.sector', '=', $request->id_sector)
                        ->get();
                } else {
                    if (empty($request->codigo_postal)) {
                        $projects = DB::table('project')
                            // ->join('proyecto_contratacion','project.id','=','proyecto_contratacion.id_project')
                            // ->join('projects_imgs','project.id','=','projects_imgs.id_project')
                            ->join('projectsector', 'project.sector', '=', 'projectsector.id')
                            ->join('project_locations', 'project.id', '=', 'project_locations.id_project')
                            ->join('locations', 'project_locations.id_location', '=', 'locations.id')
                            ->join('address', 'locations.id_address', '=', 'address.id')
                            ->select('project.*')
                            ->where('address.locality', '=', $request->municipio)
                            ->where('project.sector', '=', $request->id_sector)
                            ->where('project.subsector', '=', $request->id_subsector)
                            ->get();
                    } else {
                        $projects = DB::table('project')
                            // ->join('proyecto_contratacion','project.id','=','proyecto_contratacion.id_project')
                            // ->join('projects_imgs','project.id','=','projects_imgs.id_project')
                            ->join('projectsector', 'project.sector', '=', 'projectsector.id')
                            ->join('project_locations', 'project.id', '=', 'project_locations.id_project')
                            ->join('locations', 'project_locations.id_location', '=', 'locations.id')
                            ->join('address', 'locations.id_address', '=', 'address.id')
                            ->select('project.*')
                            ->where('address.locality', '=', $request->municipio)
                            ->where('project.sector', '=', $request->id_sector)
                            ->where('project.subsector', '=', $request->id_subsector)
                            ->where('address.postalCode', '=', $request->codigo_postal)
                            ->get();
                    }
                }
            }
        }
        


        return view('front.list-projects', [
            'projects' => $projects,
            
        ]);
    }

    public function card_projects()
    {
        $projects = DB::table('project')->orderBy('created_at', 'desc')->get();

        return view('front.card-projects', [
            'projects' => $projects
        ]);
    }

    public function project_single($id)
    {

        $project = Project::find($id);
        if ($project != null) {


            $project_documents = DB::table('project_documents')
                ->join('documents', 'project_documents.id_document', '=', 'documents.id')
                ->where('id_project', '=', $id)
                ->get();




            $identificacion = array();
            $preparacion = array();
            $contratacion = array();
            $ejecucion = array();
            $finalizacion = array();

            foreach ($project_documents as $document) {

                switch ($document->description) {
                    case 'identificacion':
                        array_push($identificacion, $document->url);
                        break;
                    case 'preparacion':
                        array_push($preparacion, $document->url);
                        break;
                    case 'contratacion':
                        array_push($contratacion, $document->url);
                        break;
                    case 'ejecucion':
                        array_push($ejecucion, $document->url);
                        break;
                    case 'finalizacion':
                        array_push($finalizacion, $document->url);
                        break;
                }
            }

            $all = DB::table('project')
                
                ->join('generaldata', 'project.id', '=', 'generaldata.id_project')
                ->leftJoin('estudiosambiental', 'project.id', '=', 'estudiosambiental.id_project')
                ->leftJoin('estudiosfactibilidad', 'project.id', '=', 'estudiosfactibilidad.id_project')
                ->leftJoin('estudiosimpacto', 'project.id', '=', 'estudiosimpacto.id_project')
                ->leftJoin('proyecto_contratacion', 'project.id', '=', 'proyecto_contratacion.id_project')
                ->leftJoin('proyecto_ejecucion', 'project.id', '=', 'proyecto_ejecucion.id_project')
                ->leftJoin('proyecto_finalizacion', 'project.id', '=', 'proyecto_finalizacion.id_project')
                ->select(
                    'project.*',
                    'generaldata.*',
                    'estudiosambiental.*',
                    'estudiosfactibilidad.*',
                    'estudiosimpacto.*',
                    'proyecto_contratacion.*',
                    'proyecto_ejecucion.*',
                    'proyecto_ejecucion.*',
                    'proyecto_finalizacion.*',
                    'project.id as id_project'
                )
                ->where('project.id', '=', $id)
                ->first();

           $responsableproyecto=DB::table('responsableproyecto')
           ->where('id_project',$id)
           ->get();
         

            $avance = 0;
            
        switch ($all->status) {
            case 1:
                $avance = 20;
                break;
            case 2:
                $avance = 40;
                break;
            case 3:
                $avance = 60;
                break;
            case 4:
                $avance = 80;
                break;
            case 5:
                $avance = 100;
                break;
            default:
                $avance = 100;
        }

            $empresas = $all->empresasparticipantes;
            $empresasparticipantes = explode(",", $empresas);

            $subsector = DB::table('subsector')
                ->where('id', '=', $project->subsector)
                ->select('titulo')
                ->first();

            //validate null 
            $tipocontrato = DB::table('cattipo_contrato')
                ->where('id', '=', $all->tipocontrato)
                ->first();
            if ($tipocontrato == null) {
                $tipocontrato = new stdClass();
                $tipocontrato->titulo = "";
            }
            $modalidadcontratacion = DB::table('catmodalidad_contratacion')
                ->where('id', '=', $all->modalidadcontrato)
                ->first();
            if ($modalidadcontratacion == null) {
                $modalidadcontratacion = new stdClass();
                $modalidadcontratacion->titulo = "";
            }


            $modalidadadjudicacion = DB::table('catmodalidad_adjudicacion')
                ->where('id', '=', $all->modalidadadjudicacion)
                ->first();
            $estadoactual = DB::table('contractingprocess_status')
                ->where('id', '=', $all->estadoactual)
                ->first();

            $project_imgs=DB::table('projects_imgs')
            ->where('id_project','=',$project->id)
            ->get();
           
          


            return view('front.project-single', [

                'project' => $all,
                'identificacion' => $identificacion,
                'preparacion' => $preparacion,
                'contratacion' => $contratacion,
                'ejecucion' => $ejecucion,
                'finalizacion' => $finalizacion,
                'empresasparticipantes' => $empresasparticipantes,
                'subsector' => $subsector,
                'tipocontrato' => $tipocontrato,
                'modalidadcontratacion' => $modalidadcontratacion,
                'modalidadadjudicacion' => $modalidadadjudicacion,
                'estadoactual' => $estadoactual,
                'project_documents' => $project_documents,
                'avance' => $avance,
                'project_imgs'=>$project_imgs,
                'responsableproyecto'=>$responsableproyecto,
            ]);
        } else {
            return redirect()->route('list-projects');
        }
    }
    public function getdocumentsproject()
    {
        $titulo = $_POST['titulo'];
        $id_project = $_POST['idproject'];


        $data = DB::table('project_documents')
            ->join('documents', 'project_documents.id_document', '=', 'documents.id')
            ->where('id_project', '=', $id_project)
            ->where('documents.description', '=', $titulo)
            ->get();


        echo json_encode($data);
    }
}
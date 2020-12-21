<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {   
        $projects = DB::table('project')
            ->join('projectsector', 'project.sector', '=', 'projectsector.id')
            ->join('project_locations', 'project.id', '=', 'project_locations.id_project')
            ->join('locations', 'project_locations.id_location', '=', 'locations.id')
            ->join('address', 'locations.id_address', '=', 'address.id')
            ->select('project.*', 'locations.id_geometry', 'locations.id_gazetter', 'locations.uri', 'locations.id_address','locations.lat', 'locations.lng') 
            ->get();
        
        return view('front.home', [
            'projects' => $projects
        ]);
    }

    public function know_more()
    {
        return view('front.know-more');
    }

    public function about_us()
    {
        return view('front.about-us');
    }

    public function resources()
    {
        return view('front.resources');
    }

    public function statistics()
    {
        return view('front.statistics');
    }

    public function interest_sites()
    {
        return view('front.interest-sites');
    }

    public function account()
    {
        $project = Project::find($id);
        if($project!=null){
            $project_documents=DB::table('project_documents')
            ->join('documents','project_documents.id_document','=','documents.id')
            ->where('id_project','=',$id)
            ->get();
            $project_ambiental=DB::table('estudiosambiental')
            ->where('id_project','=',$id)
            ->first();
            $project_factibilidad=DB::table('estudiosfactibilidad')
            ->where('id_project','=',$id)
            ->first();
            
            $project_impacto=DB::table('estudiosimpacto')
            ->where('id_project','=',$id)
            ->first();
           /* $impacto=DB::table('catimpactoterreno')
            ->where('tipoImpacto','=',$project_impacto)
            ->first();*/

            $ambiental=$project_ambiental->numeros_ambiental;
            $responsable_ambiental=$project_ambiental->responsableAmbiental;


            $factibilidad=$project_factibilidad->numeros_factibilidad;
            $responsable_factibilidad=$project_factibilidad->responsableFactibilidad;

            $impacto=$project_impacto->numeros_impacto;
            $responsable_impacto=$project_impacto->responsableImpacto;
        
            
          
           
            $subsector=DB::table('subsector')
            ->where('id','=',$project->subsector)
            ->select('titulo')
            ->first();

            $contratacion=DB::table('proyecto_contratacion')
            ->where('id_project','=',$id)
            ->first();

            $tipocontrato=DB::table('cattipo_contrato')
            ->where('id','=',$contratacion->tipocontrato)
            ->first();
            
            $modalidadcontratacion=DB::table('catmodalidad_contratacion')
            ->where('id','=',$contratacion->modalidadcontrato)
            ->first();

            $entidad_admin_contrato=$contratacion->entidad_admin_contrato;
            $titulocontrato=$contratacion->titulocontrato;
            $viapropuesta=$contratacion->viapropuesta;
            $montocontrato=$contratacion->montocontrato;
            $alcancecontrato=$contratacion->alcancecontrato;
            $duracionproyecto_contrato=$contratacion->duracionproyecto_contrato;

            $empresasparticipantes=$contratacion->empresasparticipantes;

            $empresasparticipantes = explode(",", $empresasparticipantes);

         

            $identificacion=array();
            $preparacion=array();
            $contratacion=array();
            $ejecucion=array();
            $finalizacion=array();
            
            foreach($project_documents as $document){
              
                switch($document->description){
                    case 'identificacion':
                    array_push($identificacion,$document->url);
                    break;
                    case 'preparacion':
                    array_push($preparacion,$document->url);
                    break;
                    case 'contratacion':
                    array_push($contratacion,$document->url);
                    break;
                    case 'ejecucion':
                    array_push($ejecucion,$document->url);
                    break;
                    case 'finalizacion':
                    array_push($finalizacion,$document->url);
                    break;

                }
            }
            
          

            return view('front.specific-project', [
                
            'project' => $project,
            'identificacion'=>$identificacion,
            'preparacion'=>$preparacion,
            'contratacion'=>$contratacion,
            'ejecucion'=>$ejecucion,
            'finalizacion'=>$finalizacion,
            'subsector'=>$subsector,
            'impacto'=>$impacto,
            'responsable_impacto'=>$responsable_impacto,
            'ambiental'=>$ambiental,
            'responsable_ambiental'=>$responsable_ambiental,
            'factibilidad'=>$factibilidad,
            'responsable_factibilidad'=>$responsable_factibilidad,
            'tipocontrato'=>$tipocontrato,
            'modalidadcontratacion'=>$modalidadcontratacion,
            'entidad_admin_contrato'=>$entidad_admin_contrato,
            'titulocontrato'=>$titulocontrato,
            'viapropuesta'=>$viapropuesta,
            'montocontrato'=>$montocontrato,
            'alcancecontrato'=>$alcancecontrato,
            'duracionproyecto_contrato'=>$duracionproyecto_contrato,
            'empresasparticipantes'=>$empresasparticipantes,



            

            
            ]);
        }else{
            return redirect()->route('home.listworks');
        }
      
        return view('auth.account');
    }

    public function contact_us()
    {
        return view('front.contact-us');
    }

    public function project_search(Request $request){

        if (empty($request->nombre_proyecto)) {
            if(empty($request->municipio)){
                $projects=DB::table('project')
                    ->join('projectsector','project.sector','=','projectsector.id')
                    ->join('project_locations','project.id','=','project_locations.id_project')
                    ->join('locations','project_locations.id_location','=','locations.id')
                    ->join('address','locations.id_address','=','address.id')
                    ->select('project.*','locations.*')
                    // ->where('address.locality','=',$request->municipio)
                    ->get();
            }else{
                if (empty($request->id_sector)) {
                    $projects=DB::table('project')
                    // ->join('proyecto_contratacion','project.id','=','proyecto_contratacion.id_project')
                    ->join('projectsector','project.sector','=','projectsector.id')
                    ->join('project_locations','project.id','=','project_locations.id_project')
                    ->join('locations','project_locations.id_location','=','locations.id')
                    ->join('address','locations.id_address','=','address.id')
                    ->select('project.*','locations.*')
                    ->where('address.locality','=',$request->municipio)
                    ->get();
                } else {
                    if (empty($request->id_subsector)) {
                        $projects=DB::table('project')
                        // ->join('proyecto_contratacion','project.id','=','proyecto_contratacion.id_project')
                        ->join('projectsector','project.sector','=','projectsector.id')
                        ->join('project_locations','project.id','=','project_locations.id_project')
                        ->join('locations','project_locations.id_location','=','locations.id')
                        ->join('address','locations.id_address','=','address.id')
                        ->select('project.*','locations.*')
                        ->where('address.locality','=',$request->municipio)
                        ->where('project.sector','=',$request->id_sector)
                        ->get();
                    } else {
                        if (empty($request->codigo_postal)) {
                            $projects=DB::table('project')
                            // ->join('proyecto_contratacion','project.id','=','proyecto_contratacion.id_project')
                            ->join('projectsector','project.sector','=','projectsector.id')
                            ->join('project_locations','project.id','=','project_locations.id_project')
                            ->join('locations','project_locations.id_location','=','locations.id')
                            ->join('address','locations.id_address','=','address.id')
                            ->select('project.*','locations.*')
                            ->where('address.locality','=',$request->municipio)
                            ->where('project.sector','=',$request->id_sector)
                            ->where('project.subsector','=',$request->id_subsector)
                            ->get();
                        } else {
                            $projects=DB::table('project')
                            // ->join('proyecto_contratacion','project.id','=','proyecto_contratacion.id_project')
                            ->join('projectsector','project.sector','=','projectsector.id')
                            ->join('project_locations','project.id','=','project_locations.id_project')
                            ->join('locations','project_locations.id_location','=','locations.id')
                            ->join('address','locations.id_address','=','address.id')
                            ->select('project.*','locations.*')
                            ->where('address.locality','=',$request->municipio)
                            ->where('project.sector','=',$request->id_sector)
                            ->where('project.subsector','=',$request->id_subsector)
                            ->where('address.postalCode','=',$request->codigo_postal)
                            ->get();
                        }
                        
                        
                    }
                    
                    
                }
                
            }
        } else {
            if(empty($request->municipio)){
                $projects=DB::table('project')
                    // ->join('proyecto_contratacion','project.id','=','proyecto_contratacion.id_project')
                    ->join('projectsector','project.sector','=','projectsector.id')
                    ->join('project_locations','project.id','=','project_locations.id_project')
                    ->join('locations','project_locations.id_location','=','locations.id')
                    ->join('address','locations.id_address','=','address.id')
                    ->select('project.*','locations.*')
                    // ->where('address.locality','=',$request->municipio)
                    ->orWhere('project.title','like','%'.$request->nombre_proyecto.'%')
                    ->get();
            }else{

                $projects=DB::table('project')
                    // ->join('proyecto_contratacion','project.id','=','proyecto_contratacion.id_project')
                    ->join('projectsector','project.sector','=','projectsector.id')
                    ->join('project_locations','project.id','=','project_locations.id_project')
                    ->join('locations','project_locations.id_location','=','locations.id')
                    ->join('address','locations.id_address','=','address.id')
                    ->select('project.*','locations.*')
                    ->where('address.locality','=',$request->municipio)
                    ->orWhere('project.title','like','%'.$request->nombre_proyecto.'%')
                    ->get();
                // if (empty($request->id_sector)) {
                //     $projects=DB::table('project')
                //     // ->join('proyecto_contratacion','project.id','=','proyecto_contratacion.id_project')
                //     ->join('projectsector','project.sector','=','projectsector.id')
                //     ->join('project_locations','project.id','=','project_locations.id_project')
                //     ->join('locations','project_locations.id_location','=','locations.id')
                //     ->join('address','locations.id_address','=','address.id')
                //     ->select('project.*','locations.*')
                //     ->where('address.locality','=',$request->municipio)
                //     ->where('project.title','=',$request->nombre_proyecto)
                //     ->get();
                // } else {
                //     if (empty($request->id_subsector)) {
                //         $projects=DB::table('project')
                //         // ->join('proyecto_contratacion','project.id','=','proyecto_contratacion.id_project')
                //         ->join('projectsector','project.sector','=','projectsector.id')
                //         ->join('project_locations','project.id','=','project_locations.id_project')
                //         ->join('locations','project_locations.id_location','=','locations.id')
                //         ->join('address','locations.id_address','=','address.id')
                //         ->select('project.*','locations.*')
                //         ->where('address.locality','=',$request->municipio)
                //         ->where('project.sector','=',$request->id_sector)
                //         ->get();
                //     } else {
                //         if (empty($request->codigo_postal)) {
                //             $projects=DB::table('project')
                //             // ->join('proyecto_contratacion','project.id','=','proyecto_contratacion.id_project')
                //             ->join('projectsector','project.sector','=','projectsector.id')
                //             ->join('project_locations','project.id','=','project_locations.id_project')
                //             ->join('locations','project_locations.id_location','=','locations.id')
                //             ->join('address','locations.id_address','=','address.id')
                //             ->select('project.*','locations.*')
                //             ->where('address.locality','=',$request->municipio)
                //             ->where('project.sector','=',$request->id_sector)
                //             ->where('project.subsector','=',$request->id_subsector)
                //             ->get();
                //         } else {
                //             $projects=DB::table('project')
                //             // ->join('proyecto_contratacion','project.id','=','proyecto_contratacion.id_project')
                //             ->join('projectsector','project.sector','=','projectsector.id')
                //             ->join('project_locations','project.id','=','project_locations.id_project')
                //             ->join('locations','project_locations.id_location','=','locations.id')
                //             ->join('address','locations.id_address','=','address.id')
                //             ->select('project.*','locations.*')
                //             ->where('address.locality','=',$request->municipio)
                //             ->where('project.sector','=',$request->id_sector)
                //             ->where('project.subsector','=',$request->id_subsector)
                //             ->where('address.postalCode','=',$request->codigo_postal)
                //             ->get();
                //         }
                        
                        
                //     }
                    
                    
                    
                // }
                
            }
        }
        

        

        // $projects = DB::table('project')->get();
      
        return view('front.project_search', [
            'projects' => $projects
        ]);
    public function sitemap()
    {
        return view('front.sitemap');
    }
    
    public function support_material()
    {
        return view('front.support-material');
    }

    public function journal()
    {
        return view('front.journal');
    }
    public function listworks(Request $request){

        // dd($request->all());

        if(empty($request->municipio)){
            $projects = DB::table('project')->orderBy('created_at', 'desc')->get();
        }else{
            if (empty($request->id_sector)) {
                $projects=DB::table('project')
                // ->join('proyecto_contratacion','project.id','=','proyecto_contratacion.id_project')
                ->join('projectsector','project.sector','=','projectsector.id')
                ->join('project_locations','project.id','=','project_locations.id_project')
                ->join('locations','project_locations.id_location','=','locations.id')
                ->join('address','locations.id_address','=','address.id')
                ->select('project.*')
                ->where('address.locality','=',$request->municipio)
                ->get();
            } else {
                if (empty($request->id_subsector)) {
                    $projects=DB::table('project')
                    // ->join('proyecto_contratacion','project.id','=','proyecto_contratacion.id_project')
                    ->join('projectsector','project.sector','=','projectsector.id')
                    ->join('project_locations','project.id','=','project_locations.id_project')
                    ->join('locations','project_locations.id_location','=','locations.id')
                    ->join('address','locations.id_address','=','address.id')
                    ->select('project.*')
                    ->where('address.locality','=',$request->municipio)
                    ->where('project.sector','=',$request->id_sector)
                    ->get();
                } else {
                    if (empty($request->codigo_postal)) {
                        $projects=DB::table('project')
                        // ->join('proyecto_contratacion','project.id','=','proyecto_contratacion.id_project')
                        ->join('projectsector','project.sector','=','projectsector.id')
                        ->join('project_locations','project.id','=','project_locations.id_project')
                        ->join('locations','project_locations.id_location','=','locations.id')
                        ->join('address','locations.id_address','=','address.id')
                        ->select('project.*')
                        ->where('address.locality','=',$request->municipio)
                        ->where('project.sector','=',$request->id_sector)
                        ->where('project.subsector','=',$request->id_subsector)
                        ->get();
                    } else {
                        $projects=DB::table('project')
                        // ->join('proyecto_contratacion','project.id','=','proyecto_contratacion.id_project')
                        ->join('projectsector','project.sector','=','projectsector.id')
                        ->join('project_locations','project.id','=','project_locations.id_project')
                        ->join('locations','project_locations.id_location','=','locations.id')
                        ->join('address','locations.id_address','=','address.id')
                        ->select('project.*')
                        ->where('address.locality','=',$request->municipio)
                        ->where('project.sector','=',$request->id_sector)
                        ->where('project.subsector','=',$request->id_subsector)
                        ->where('address.postalCode','=',$request->codigo_postal)
                        ->get();
                    }
                    
                    
                }
                
                
                
            }
            
        }

      
        return view('front.listworks', [
            'projects' => $projects
        ]);

    public function organizations()
    {
        $publicos = DB::table('dir_org')
            ->where('sector', '=', 'Sector Público')
            ->get();
        $academicos = DB::table('dir_org')
            ->where('sector', '=', 'Sector Académico')
            ->get();
        $privados = DB::table('dir_org')
            ->where('sector', '=', 'Sector Privado')
            ->get();
        $organizados = DB::table('dir_org')
            ->where('sector', '=', 'Sociedad Civil Organizada')
            ->get();
        $estrategicos = DB::table('dir_org')
            ->where('sector', '=', 'Aliados Estratégicos')
            ->get();

        return view('front.organizations', [
            'publicos' => $publicos,
            'academicos' => $academicos,
            'privados' => $privados,
            'organizados' => $organizados,
            'estrategicos' => $estrategicos,
        ]);
    }
    public function supportmaterial(){
        return view('front.supportmaterial');
    }


    public function sectores(Request $request){

        if ($request->ajax()) {
            $sectores=DB::table('project')
            ->join('projectsector','project.sector','=','projectsector.id')
            ->join('project_locations','project.id','=','project_locations.id_project')
            ->join('locations','project_locations.id_location','=','locations.id')
            ->join('address','locations.id_address','=','address.id')
            ->select('projectsector.*')
            ->where('address.locality','=',$request->municipio_id)
            ->get();
            if (count($sectores)==0) {
                $sectoresArray[0] = 'No se encontraron sectores';
            } else {
                foreach ($sectores as $sector) {
                    $sectoresArray[$sector->id] = $sector->titulo;
                }
            }
            
            
            return response()->json($sectoresArray);
        }
        

    }

    public function subsectores(Request $request){

        
        if ($request->ajax()) {
            $sub_sectores=DB::table('subsector')
            ->join('sectorsubsector','subsector.id','=','sectorsubsector.id_subsector')
            ->join('projectsector','sectorsubsector.id_sector','=','projectsector.id')
            // ->join('locations','project_locations.id_location','=','locations.id')
            // ->join('address','locations.id_address','=','address.id')
            ->select('subsector.*')
            ->where('projectsector.id','=',$request->sector_id)
            ->get();
            

            if (count($sub_sectores)==0) {
                $subsectoresArray[0] = 'No se encontraron subsectores';
            } else {
                foreach ($sub_sectores as $sub_sector) {
                    $subsectoresArray[$sub_sector->id] = $sub_sector->titulo;
                }
            }
            
            
            return response()->json($subsectoresArray);
        }
    }
    public function codigo_postales(Request $request){

        
        if ($request->ajax()) {
            $codigo_postales=DB::table('project')
            ->join('projectsector','project.sector','=','projectsector.id')
            ->join('project_locations','project.id','=','project_locations.id_project')
            ->join('locations','project_locations.id_location','=','locations.id')
            ->join('address','locations.id_address','=','address.id')
            ->select('address.*')
            ->where('project.subsector','=',$request->sub_sector_id)
            ->get();

            if (count($codigo_postales)==0) {
                $codigo_postalesArray[0] = 'No hay codigo postal';
            } else {
                foreach ($codigo_postales as $codigo_postal) {
                    $codigo_postalesArray[$codigo_postal->postalCode] = $codigo_postal->postalCode;
                }
            }
            
            
            return response()->json($codigo_postalesArray);
        }
    }

    public function journal(){
        return view('front.journal');
    }

}

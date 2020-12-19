<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProjectStatus;
use App\Models\ProjectSector;
use App\Http\Controllers\Controller;
use App\Http\Requests\RequestIdentificacion;
use App\Models\Project;
use App\Models\Period;
use App\Models\ProjectType;
use App\Models\Organization;
use App\Models\Address;
use App\Models\BudgetBreakdown;
use App\Models\Completion;
use App\Models\Locations;
use App\Models\Documents;
use App\Models\DocumentType;
use App\Models\Estudios;
use App\Models\ProjectDocuments;
use App\Models\ProjectLocations;
use App\Models\SubSector;
use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\CommonMark\Block\Element\Document;
use stdClass;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    
    public function index()
    {
        //
       
        $id_user=Auth::user()->id;
        
        $projects=DB::table('project')
        ->join('generaldata','project.id','=','generaldata.id_project')
        ->leftJoin('project_organizations','project.id','=','project_organizations.id_project')
        ->leftJoin('organization','project_organizations.id_organization','=','organization.id')
        ->leftJoin('proyecto_contratacion','project.id','=','proyecto_contratacion.id_project')
        ->join('doproject','project.id','=','doproject.id_project')
        ->where('doproject.id_user','=',$id_user)
        ->select('project.*','project.id as id_project','organization.name  as orgname',
        'proyecto_contratacion.montocontrato as montocontrato','generaldata.*')
         ->get();

      // $projects=Project::all()
      // ->select('project.id as id_project');

     // print_r($projects);
   

        if(empty($projects[0])){

            
            $projects = Project::orderBy('project.created_at', 'desc')
            ->join('project_organizations','project.id','=','project_organizations.id_project')
            ->join('organization','project_organizations.id_organization','=','organization.id')
            ->join('doproject','project.id','=','doproject.id_project')
            ->where('doproject.id_user','=',$id_user)
            ->select('project.*','project.id as id_project','organization.name  as orgname')
            ->get();   
            


           
            
        }
     
     
       
        return view('admin.projects.index',['projects'=>$projects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    

    public function create()
    {
        //

        // $status=DB::table('projectstatus')->select('*')->get();
        $status = ProjectStatus::all();
        $sector = ProjectSector::all();
        $type = ProjectType::all();
        $autoridadPublica = Organization::all();
        return view(
            'admin.projects.proyecto',
            [
                'status' => $status,
                'sectores' => $sector,
                'types' => $type,
                'autoridadP' => $autoridadPublica,


            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function generaldata($id=null){

            //cuando ya hay datos.
            if($id!=null){
             

                $generaldata=DB::table('generaldata')
                ->where('id_project','=',$id)
                ->first();
            
              
                      
                return view('admin.projects.generaldata',[
                    'project'=> Project::find($id),
                    'nav'=>'generaldata',
                    'edit'=>true,
                    'ruta'=>'project.savegeneraldata',
                    'generaldata'=>$generaldata,
                ]);

            }else{  
                $generaldata = new stdClass();
                $generaldata->id_project = '';
                $generaldata->descripcion='';
                $generaldata->responsable='';
                $generaldata->email='';
                $generaldata->organismo='';
                $generaldata->puesto='';
                $generaldata->involucrado='';
            return view('admin.projects.generaldata',[
                'project'=>new Project(),
                'nav'=>'generaldata',
                'edit'=>false,
                'ruta'=>'project.savegeneraldata',
                'generaldata'=>$generaldata,
            ]);
            }
           

            
    }
    public function savegeneraldata(Request $request){
       
        $project = new Project();  

        $request->validate([
          
            'nombreresponsable'=>'required|max:50',
            'email'=>'required|max:50',
            'organismo'=>'required|max:255',
            'puesto'=>'required|max:255',
            'involucrado'=>'required|max:50',
           
            
        ]);
       
        
        $project->status=7;
        $project->save();

    
       
        if($request->hasFile('images')){

            for ($i=0; $i <sizeof($request->images) ; $i++) { 
            $nombre_img = $_FILES['images']['name'][$i];
            $url=time().$nombre_img;
            move_uploaded_file($_FILES['images']['tmp_name'][$i],'projects_imgs/'.$url);
            

            DB::table('projects_imgs')->insert([
                'id_project'=>$project->id,
                'imgroute'=>$url,
            ]);
    
        }
    }
        
        $r=DB::table('generaldata')
        ->insert([
            'id_project'=>$project->id,
            'descripcion'=>$request->descripcion,
            'responsable'=>$request->nombreresponsable,
            'email'=>$request->email,
            'organismo'=>$request->organismo,
            'puesto'=>$request->puesto,
            'involucrado'=>$request->involucrado,

        ]);

        DB::table('doproject')
        ->insert([
            'id_project'=>$project->id,
            'id_user'=>Auth::user()->id,
        ]);

        return redirect()->route('project.editidentificacion',['project'=>$project->id]);;

    }
   
     public function identificacion($id=null){
        $project=Project::find($id);

   
       
        if(!empty($project)){


            $sectors = ProjectSector::all();
            $types=ProjectType::all();
            
            $autoridadPublica = Organization::all();
            $documentstype=DocumentType::all();

            if($project->title==""){
                return view('admin.projects.identificacion',
                [
                   'project'=>$project,
                   'nav'=>'identificacion',
                   'documentstype'=>$documentstype,
                   'sectors'=>$sectors,
                   'autoridadP'=>$autoridadPublica,
                   'types'=>$types,
                   'edit'=>false,
                   'ruta'=>'project.saveidentificacion',
                
                
                ]);
            }else{

                $documents=DB::table('project')
                ->join('project_documents','project.id','=','project_documents.id_project')
                ->join('documents','project_documents.id_document','=','documents.id')
                ->where('project.id','=',$id)
                ->where('documents.description','=','identificacion')
                ->select('documents.url','documents.id')
                ->get();
        
                
              
              
                $data_project=DB::table('project')
                ->join('project_locations','project.id','=','project_locations.id_project')
                ->join('locations','project_locations.id_location','=','locations.id')
                ->join('address','locations.id_address','=','address.id')
                ->select('project.*','project.description as descripcionProyecto','locations.lat','locations.lng','locations.description as description','address.streetAddress',
                'address.locality','address.region','address.postalCode','address.countryName')
                ->where('project.id','=',$id)
                ->first();
              
                return view('admin.projects.identificacion',
                [
                    'project'=>$data_project,
                 
                    'documentstype'=> $documentstype,
                    'documents'=>$documents,
                   'nav'=>'identificacion',
                   'sectors'=>$sectors,
                   'autoridadP'=>$autoridadPublica,
                   'types'=>$types,
                   'edit'=>true,
                   'ruta'=>'project.updateidentificacion',
       
                
                
                ]);
            }




        
           
            
           
           
        }
    
         

           
        

      
     }
     public function editidentificacion($id){
        
        $p=Project::find($id);
        if(!empty($p)){
       
        $sectors = ProjectSector::all();
        $types=ProjectType::all();
        $documentstype=DocumentType::all();
        $autoridadPublica = Organization::all();
           
        $documents=DB::table('project')
        ->join('project_documents','project.id','=','project_documents.id_project')
        ->join('documents','project_documents.id_document','=','documents.id')
        ->where('project.id','=',$id)
        ->where('documents.description','=','identificacion')
        ->select('documents.url','documents.id')
        ->get();

        
      
      
        $data_project=DB::table('project')
        ->join('project_locations','project.id','=','project_locations.id_project')
        ->join('locations','project_locations.id_location','=','locations.id')
        ->join('address','locations.id_address','=','address.id')
        ->select('project.*','project.description as descripcionProyecto','locations.lat','locations.lng','locations.description as description','address.streetAddress',
        'address.locality','address.region','address.postalCode','address.countryName')
        ->where('project.id','=',$id)
        ->first();
      

     


    

         return view('admin.projects.identificacion',
         [
             'project'=>$data_project,
          
             'documentstype'=> $documentstype,
             'documents'=>$documents,
            'nav'=>'identificacion',
            'sectors'=>$sectors,
            'autoridadP'=>$autoridadPublica,
            'types'=>$types,
            'edit'=>true,
            'ruta'=>'project.updateidentificacion',

         
         
         ]);
        }else{
           //
            return redirect()->route('project.identificacion');
        }
     }
     public function preparacion($id=null){
     
       
        if(!empty($id)){

            
            $catfac=DB::table('catfac')->get();
            $catambiental=DB::table('catambiental')->get();
            $catimpacto=DB::table('catimpactoterreno')->get();
            $catorigenrecurso=DB::table('catorigenrecurso')->get();
            
            $documents=DB::table('project')
        ->join('project_documents','project.id','=','project_documents.id_project')
        ->join('documents','project_documents.id_document','=','documents.id')
        ->where('project.id','=',$id)
        ->wherE('documents.description','=','preparacion')
        ->select('documents.url','documents.id')
        ->get();

      
            
            $project=DB::table('project')
            ->join('estudiosambiental','project.id','=','estudiosambiental.id_project')
            ->join('estudiosfactibilidad','project.id','=','estudiosfactibilidad.id_project')
            ->join('estudiosimpacto','project.id','=','estudiosimpacto.id_project')
            ->join('project_budgetbreakdown','project.id','=','project_budgetbreakdown.id_project')
            ->join('budget_breakdown','project_budgetbreakdown.id_budget','=','budget_breakdown.id')
            ->join('period','budget_breakdown.id_period','=','period.id')
            ->where('project.id','=',$id)
            ->select('estudiosambiental.*','estudiosfactibilidad.*','estudiosimpacto.*'
            ,'project.id as id','project.status','budget_breakdown.description',
            'budget_breakdown.sourceParty_name',
            'period.startDate as iniciopresupuesto')
            ->first();//solo un registro.
            //description = origenRecurso
           // print_r($project);
          
            if($project==null){
                $project=Project::find($id);
                $medit=false;
                
                if($project==null){
                    return redirect()->route('project.identificacion');
                }
                return view('admin.projects.preparacion',
                [   
                    'project'=>$project,
                    'nav'=>'preparacion',
                    'documents'=>$documents,
                    'catfacs'=>$catfac,
                    'catambientals'=>$catambiental,
                    'catimpactos'=>$catimpacto,
                    'catorigenrecurso'=>$catorigenrecurso,
                    'medit'=>$medit,
                    'edit'=>true,
                    'ruta'=>'project.savepreparacion',
                    
                
                
                ]);
            }else{
   
                $medit=true;
          

          
                return view('admin.projects.preparacion',
                [   
                    'project'=>$project,
                    'nav'=>'preparacion',
                    'documents'=>$documents,
                    'catfacs'=>$catfac,
                    'catambientals'=>$catambiental,
                    'catimpactos'=>$catimpacto,
                    'catorigenrecurso'=>$catorigenrecurso,
                    'edit'=>true,
                    'medit'=>$medit,
                    'ruta'=>'project.updatepreparacion',
                
                
                ]);
            }
         
        
        }
        
            else{
            return redirect()->route('project.identificacion');
           
        }
     }
     public function contratacion($id=null){
         if(empty($id)){
            return redirect()->route('project.identificacion');
        }else{


            $checkambiental= DB::table('estudiosambiental')
            ->where('id_project','=',$id)
            ->get();
            if(empty($checkambiental[0])){
                        
                return redirect()->route('project.preparacion',['project'=>$id]);
            }

            $documents=DB::table('project')
            ->join('project_documents','project.id','=','project_documents.id_project')
            ->join('documents','project_documents.id_document','=','documents.id')
            ->where('project.id','=',$id)
            ->where('documents.description','=','contratacion')
            ->select('documents.url','documents.id')
            ->get();
           

            $project=DB::table('proyecto_contratacion')
            ->join('project','proyecto_contratacion.id_project','=','project.id')
            ->select('proyecto_contratacion.*','project.status','project.id as id')
            ->where('id_project','=',$id)
            ->first();
          
            $catmodalidad_adjudicacion=DB::table('catmodalidad_adjudicacion')->get();
            $cattipo_contrato=DB::table('cattipo_contrato')->get();
            $catmodalidad_contratacion=DB::table('catmodalidad_contratacion')->get();
            $contractingprocess_status=DB::table('contractingprocess_status')->get();
           
        

           if($project==null){
          
            $project=Project::find($id);
            return view('admin.projects.contratacion',
            [   
                'project'=>$project,
                'nav'=>'contratacion',
                'documents'=>$documents,
                'edit'=>true,
                'catmodalidad_adjudicacion'=>$catmodalidad_adjudicacion,
                'cattipo_contrato'=>$cattipo_contrato,
                'catmodalidad_contratacion'=>$catmodalidad_contratacion,
                'contractingprocess_status'=>$contractingprocess_status,
                'medit'=>false,
                'ruta'=>'project.savecontratacion',
            
            
            ]);
           }else{
            return view('admin.projects.contratacion',
            [   
                'project'=>$project,
                'nav'=>'contratacion',
                'documents'=>$documents,
                'edit'=>true,
                'catmodalidad_adjudicacion'=>$catmodalidad_adjudicacion,
                'cattipo_contrato'=>$cattipo_contrato,
                'catmodalidad_contratacion'=>$catmodalidad_contratacion,
                'contractingprocess_status'=>$contractingprocess_status,
                'medit'=>true,
                'ruta'=>'project.updatecontratacion',
            
            ]);
           }

          

           

    
    } 
     }

     public function ejecucion($id=null){

        if(!empty($id)){

        
            $project=DB::table('proyecto_ejecucion')
            ->join('project','proyecto_ejecucion.id_project','=','project.id')
            ->select('proyecto_ejecucion.*','project.status','project.id as id')
            ->where('id_project','=',$id)
            ->first();
            $documents=DB::table('project')
        ->join('project_documents','project.id','=','project_documents.id_project')
        ->join('documents','project_documents.id_document','=','documents.id')
        ->where('project.id','=',$id)
        ->wherE('documents.description','=','ejecucion')
        ->select('documents.url','documents.id')
        ->get();
            if($project==null){

                $project=Project::find($id);
                
              
                if($project==null){
                    return redirect()->route('project.contratacion',['project'=>$id]);
                }else{
                    if($project->status!=3){
                        return redirect()->route('project.contratacion',['project'=>$id]);
                    }
    
                    return view('admin.projects.ejecucion',
                    [
                        'project'=>$project,
                        'documents'=>$documents,
                        'nav'=>'ejecucion',
                        'edit'=>true,
                        'medit'=>false,
                        'ruta'=>'project.saveejecucion',
                       
                    ]);
                }
              
                
                
            }else{
                return view('admin.projects.ejecucion',
                [
                    'project'=>$project,
                    'documents'=>$documents,
                    'nav'=>'ejecucion',
                    'edit'=>true,
                    'medit'=>true,
                    'ruta'=>'project.updateejecucion',
                   
                ]);
            }
    
    
           
    
        }
        
        

      
     }
     public function finalizacion($id=null){
        if($id!=null){

            $project=DB::table('proyecto_finalizacion')
            ->join('project','proyecto_finalizacion.id_project','=','project.id')
            ->select('proyecto_finalizacion.*','project.status','project.id as id')
            ->where('id_project','=',$id)
            ->first();
            $documents=DB::table('project')
        ->join('project_documents','project.id','=','project_documents.id_project')
        ->join('documents','project_documents.id_document','=','documents.id')
        ->where('project.id','=',$id)
        ->wherE('documents.description','=','finalizacion')
        ->select('documents.url','documents.id')
        ->get();
            
            if($project==null){
           
             
              $project=Project::find($id);
                
          
           
            
            
             
              if($project==null){
                return redirect()->route('project.ejecucion',['project'=>$id]);
               
              }else{
                if($project->status!=4){
                    return redirect()->route('project.ejecucion',['project'=>$id]);
                }
                return view('admin.projects.finalizacion',
                [   
                    'project'=>$project,
                    'documents'=>$documents,
                    'nav'=>'finalizacion',
                    'edit'=>true,
                    'medit'=>false,
                    'ruta'=>'project.savefinalizacion',
                  
                ]);
              } 
              
            }else{

                
               
                return view('admin.projects.finalizacion',
                [   
                    'project'=>$project,
                    'documents'=>$documents,
                    'nav'=>'finalizacion',
                    'edit'=>true,
                    'medit'=>true,
                    'ruta'=>'project.updatefinalizacion',
                ]);
                
       
    }
    }

     }

     public function updateidentificacion(Request $request){
        $fecha_in = date('Y-m-d');

       
        $project = Project::find($request->id_project);

    
        $project->updated = $fecha_in;
        $project->title = $request->tituloProyecto;
        $project->ocid=$request->ocid;
        $project->description = $request->descripcionProyecto;
    
       
        $project->sector = $request->sectorProyecto;
        $project->subsector=$request->subsector;
        $project->purpose = $request->propositoProyecto;
        $project->type = $request->tipoProyecto;
        $project->people=$request->people;
      
        $project->publicAuthority_name = '';
        $project->publicAuthority_id = $request->autoridadP;
        
       

       



        $project_location=DB::table('project_locations')
        ->select('id_location')
        ->where('id_project','=',$project->id)
        ->first();

   

        $locations = Locations::find($project_location->id_location);

      
        $locations->description = $request->description;
        $locations->id_geometry = 1;
        $locations->id_gazetter = 1;
        $locations->lat = $request->lat;
        $locations->lng = $request->lng;
       

        $address=Address::find($locations->id_address);
        $address->streetAddress = $request->streetAddress;
        $address->locality = $request->locality;
        $address->region = $request->region;
        $address->postalCode = $request->postalCode;
        $address->countryName = $request->countryName;

    
        


      


    
        $address->save();
        $locations->save();
        $project->save();

        if(!empty($request->docfase1)){    
            
         

            for ($i=0; $i < sizeof($request->docfase1); $i++) { 
                $nombre_img = $_FILES['docfase1']['name'][$i];

                move_uploaded_file($_FILES['docfase1']['tmp_name'][$i],'documents/'.$nombre_img);
                $url=$nombre_img;
        
               
                
        
                $documents=new Documents();
                $documents->documentType=$request->documenttype;
                $documents->description="identificacion";
                $documents->url=$url;
                $documents->save();
        
                $projectdocuments=new ProjectDocuments();
                $projectdocuments->id_project=$project->id;
                $projectdocuments->id_document=$documents->id;
                $projectdocuments->save();

            }
            
     
        }

        $r=DB::table('generaldata')
        ->where('id_project','=',$project->id)
        ->update([
            'descripcion'=>$request->descripcion,
            'responsable'=>$request->nombreresponsable,
            'email'=>$request->email,
            'organismo'=>$request->organismo,
            'puesto'=>$request->puesto,
            'involucrado'=>$request->involucrado,
            
        ]);

        return back()->with('status', '¡La fase de identificación ha sido actualizada correctamente!');


     }
     public function updatepreparacion(Request $request){
        $fecha_in = date('Y-m-d');
       
        $request->validate([
            'tipoAmbiental'=>'required',
        'fecharealizacionAmbiental'=>'required|max:50',
        'responsableAmbiental'=>'required|max:255',
        'numeros_ambiental'=>'required',
            
            'tipoFactibilidad'=>'required',
        'fecharealizacionFactibilidad'=>'required|max:50',
        'responsableFactibilidad'=>'required|max:255',
        'numeros_factibilidad'=>'required',

        'tipoImpacto'=>'required',
        'fecharealizacionImpacto'=>'required|max:50',
        'responsableImpacto'=>'required|max:255',
        'numeros_impacto'=>'required',

        'origenrecurso'=>'required',
        'fuenterecurso'=>'required|max:255',
        'fecharecurso'=>'required|max:50'
        
        ]);
        
      

        DB::table('estudiosambiental')
            ->where('id_project','=',$request->id_project)
            ->update([
            'id_project'=>$request->id_project,
            'descripcionAmbiental'=>$request->descripcionAmbiental,
            'tipoAmbiental'=>$request->tipoAmbiental,
            'fecharealizacionAmbiental'=>$request->fecharealizacionAmbiental,
            'responsableAmbiental'=>$request->responsableAmbiental,
            'numeros_ambiental'=>$request->numeros_ambiental,
        ]);

        DB::table('estudiosfactibilidad')
            ->where('id_project','=',$request->id_project)
            ->update([
            'id_project'=>$request->id_project,
            'descripcionFactibilidad'=>$request->descripcionFactibilidad,
            'tipoFactibilidad'=>$request->tipoFactibilidad,
            'fecharealizacionFactibilidad'=>$request->fecharealizacionFactibilidad,
            'responsableFactibilidad'=>$request->responsableFactibilidad,
            'numeros_factibilidad'=>$request->numeros_factibilidad,
        ]);
        DB::table('estudiosimpacto')
            ->where('id_project','=',$request->id_project)
            ->update([
            'id_project'=>$request->id_project,
            'descripcionImpacto'=>$request->descripcionImpacto,
            'tipoImpacto'=>$request->tipoImpacto,
            'fecharealizacionImpacto'=>$request->fecharealizacionImpacto,
            'responsableImpacto'=>$request->responsableImpacto,
            'numeros_impacto'=>$request->numeros_impacto,
        ]);

      
       
        $project_budget=DB::table('project_budgetbreakdown')
        ->where('id_project','=',$request->id_project)
        ->first();
        
       

      
        $presupuesto=BudgetBreakdown::find($project_budget->id_budget);
        $presupuesto->description=$request->origenrecurso;
        $presupuesto->sourceParty_name=$request->fuenterecurso;
       
        
        $period=Period::find($presupuesto->id_period);
        $period->startDate=$request->fecharecurso;
        
        
        $period->save();
        $presupuesto->save();

           //Guardar el documento y la relación con su proyecto.
           if(!empty($request->documentospreparacion)){
            
            for ($i=0; $i <sizeof($request->documentospreparacion) ; $i++) { 
                $nombre_img = $_FILES['documentospreparacion']['name'][$i];
    
                move_uploaded_file($_FILES['documentospreparacion']['tmp_name'][$i],'documents/'.$nombre_img);
                $url=$nombre_img;
        
               
                
        
                $documents=new Documents();
                $documents->documentType=1;
                $documents->description="preparacion";
                $documents->url=$url;
                $documents->save();
        
                $projectdocuments=new ProjectDocuments();
                $projectdocuments->id_project=$request->id_project;
                $projectdocuments->id_document=$documents->id;
                $projectdocuments->save();
                }
            }

        

        return back()->with('status', '¡La fase de preparación ha sido actualizada correctamente!');
       
     }
     public function updatecontratacion(Request $request){

        if(!empty($request->fechapublicacion)){
            $request->validate([
            
                'fechapublicacion'=>'date|before:fechapresentacionpropuesta',
                'fechapresentacionpropuesta'=>'date|before:fechainiciocontrato|after:fechapublicacion',
                'fechainiciocontrato'=>'date|after:fechapresentacionpropuesta|after:fechapublicacion',
                
            ]);
        }

        
        $procedimiento_contratacion=DB::table('proyecto_contratacion')
        ->where('id_project','=',$request->id_project)
        ->update([
            'id_project'=>$request->id_project,
            'descripcion'=>$request->descripcion,
            'fechapublicacion'=>$request->fechapublicacion,
            
            'entidadadjudicacion'=>$request->entidadadjudicacion,
            'datosdecontacto'=>$request->datosdecontacto,
            'nombreresponsable'=>$request->nombreresponsable,
            'modalidadadjudicacion'=>$request->modalidadadjudicacion,
            'tipocontrato'=>$request->tipocontrato,
            'modalidadcontrato'=>$request->modalidadcontrato,
            'estadoactual'=>$request->estadoactual,
            'empresasparticipantes'=>$request->empresasparticipantes,
            'entidad_admin_contrato'=>$request->entidad_admin_contrato,
            'titulocontrato'=>$request->titulocontrato,
            'empresacontratada'=>$request->empresacontratada,
            'viapropuesta'=>$request->viapropuesta,
            'fechapresentacionpropuesta'=>$request->fechapresentacionpropuesta,
            'montocontrato'=>$request->montocontrato,
            'alcancecontrato'=>$request->alcancecontrato,
            'fechainiciocontrato'=>$request->fechainiciocontrato,
            'duracionproyecto_contrato'=>$request->duracionproyecto_contrato,
                   

        ]);


        ProjectController::havedocuments($request,'contratacion');

        if($procedimiento_contratacion){
            return back()->with('status', '¡La fase de contratación ha sido actualizada correctamente!');
       
        }else{
            return back()->with('status', 'La información no ha podido ser registrada');
        }
    }

     public function updateejecucion(Request $request){
        
        $proyecto_ejecucion=DB::table('proyecto_ejecucion')
        ->where('id_project','=',$request->id_project)
        ->update([
            'id_project'=>$request->id_project,
            'descripcion'=>$request->descripcion,
            'variacionespreciocontrato'=>$request->variacionespreciocontrato,
            'razonescambiopreciocontrato'=>$request->razonescambiopreciocontrato,
            'variacionesduracioncontrato'=>$request->variacionesduracioncontrato,
            'razonescambioduracioncontrato'=>$request->razonescambioduracioncontrato,
            'variacionesalcancecontrato'=>$request->variacionesalcancecontrato,
            'razonescambiosalcancecontrato'=>$request->razonescambiosalcancecontrato,
            'aplicacionescalatoria'=>$request->aplicacionescalatoria,
            'estadoactualproyecto'=>$request->estadoactualproyecto,


        ]);

           ProjectController::havedocuments($request,'ejecucion');

        

        if($proyecto_ejecucion){
         

            return back()->with('status', '¡La fase de ejecución ha sido actualizada correctamente!');
        }else{
            return back()->with('status', '¡La fase de ejecución no ha podido actualizarse!');
        }
     }
     public function updatefinalizacion(Request $request){
         
        $proyecto_finalizacion=DB::table('proyecto_finalizacion')
        ->where('id_project','=',$request->id_project)
        ->update([
            'id_project'=>$request->id_project,
            'descripcion'=>$request->descripcion,
            'costofinalizacion'=>$request->costofinalizacion,
            'fechafinalizacion'=>$request->fechafinalizacion,
            'alcancefinalizacion'=>$request->alcancefinalizacion,
            'razonescambioproyecto'=>$request->razonescambioproyecto,
            'referenciainforme'=>$request->referenciainforme,


        ]);
        ProjectController::havedocuments($request,'finalizacion');
        if($proyecto_finalizacion){
            return back()->with('status', '¡La fase de finalización ha sido actualizada correctamente!');
        }else{
            return back()->with('status', '¡La información no ha podido ser registrada!');
        }
        
     }
     public function savefinalizacion(Request $request){
        /*
        $request->validate([
            
            'descripcion'=>'max:50',
            'costofinalizacion'=>'max:50',
            'fechafinalizacion'=>'max:50',
            'alcancefinalizacion'=>'max:50',
            'razonescambioproyecto'=>'max:50',
            'referenciainforme'=>'max:50',
            
        ]);
        */

         $proyecto_finalizacion=DB::table('proyecto_finalizacion')
         ->insert([
             'id_project'=>$request->id_project,
             'descripcion'=>$request->descripcion,
             'costofinalizacion'=>$request->costofinalizacion,
             'fechafinalizacion'=>$request->fechafinalizacion,
             'alcancefinalizacion'=>$request->alcancefinalizacion,
             'razonescambioproyecto'=>$request->razonescambioproyecto,
             'referenciainforme'=>$request->referenciainforme,
 
 
         ]);
         ProjectController::havedocuments($request,'finalizacion');
 
         if($proyecto_finalizacion){
             DB::table('project')
             ->where('id',$request->id_project)
             ->update(['status'=>5]);
 
             return back()->with('status', '¡El formulario ha sido completado y guardado correctamente!');
         }else{
            
         }
 


        
     }
     public function saveejecucion(Request $request){

        /*

       $request->validate([
        'variacionespreciocontrato'=>'max:50',
        'razonescambiopreciocontrato'=>'max:50',
        'variacionesduracioncontrato'=>'max:50',
        'razonescambioduracioncontrato'=>'max:50',
        'variacionesalcancecontrato'=>'max:50',

        'razonescambiosalcancecontrato'=>'max:50',
        'aplicacionescalatoria'=>'max:50',
        'estadoactualproyecto'=>'max:50',

        ]);  
     */
        
        $proyecto_ejecucion=DB::table('proyecto_ejecucion')
        ->insert([
            'id_project'=>$request->id_project,
            'descripcion'=>$request->descripcion,
            'estadoactualproyecto'=>$request->estadoactualproyecto,


        ]);
        ProjectController::havedocuments($request,'ejecucion');

        if($proyecto_ejecucion){
            DB::table('project')
            ->where('id',$request->id_project)
            ->update(['status'=>4]);

            return redirect()->route('project.finalizacion',[
                'project'=>$request->id_project,
                ]);;
        }else{
           
        }

     }

     public function savecontratacion(Request $request){
        /*
        $request->validate([
        
        'datosdecontacto'=>'max:50',
        'fechapublicacion'=>'max:50',
            
        'entidadadjudicacion'=>'max:50',
        'nombreresponsable'=>'max:50',
        'modalidadadjudicacion'=>'max:50',

        'tipocontrato'=>'max:50',
        'modalidadcontrato'=>'max:50',
        'estadoactual'=>'required|max:50',

        'empresasparticipantes'=>'max:250',
        'entidad_admin_contrato'=>'max:50',

        'titulocontrato'=>'max:50',
        'empresacontratada'=>'max:50',
        'viapropuesta'=>'max:50',

        'fechapresentacionpropuesta'=>'required|max:50',
        'montocontrato'=>'max:50',
        'alcancecontrato'=>'max:50',
        'fechainiciocontrato'=>'max:50',
        'duracionproyecto_contrato'=>'max:50',
        
        ]);
        */

        if(!empty($request->fechapublicacion)){
            $request->validate([
            
                'fechapublicacion'=>'date|before:fechapresentacionpropuesta',
                'fechapresentacionpropuesta'=>'date|before:fechainiciocontrato|after:fechapublicacion',
                'fechainiciocontrato'=>'date|after:fechapresentacionpropuesta|after:fechapublicacion',
                
            ]);
        }
       

        $procedimiento_contratacion=DB::table('proyecto_contratacion')
        ->insert([
            'id_project'=>$request->id_project,
            'descripcion'=>$request->descripcion,
            'fechapublicacion'=>$request->fechapublicacion,
            'entidadadjudicacion'=>$request->entidadadjudicacion,
            'datosdecontacto'=>$request->datosdecontacto,
            'nombreresponsable'=>$request->nombreresponsable,
            'modalidadadjudicacion'=>$request->modalidadadjudicacion,
            'tipocontrato'=>$request->tipocontrato,
            'modalidadcontrato'=>$request->modalidadcontrato,
            'estadoactual'=>$request->estadoactual,
            'empresasparticipantes'=>$request->empresasparticipantes,
            'entidad_admin_contrato'=>$request->entidad_admin_contrato,
            'titulocontrato'=>$request->titulocontrato,
            'empresacontratada'=>$request->empresacontratada,
            'viapropuesta'=>$request->viapropuesta,
            'fechapresentacionpropuesta'=>$request->fechapresentacionpropuesta,
            'montocontrato'=>$request->montocontrato,
            'alcancecontrato'=>$request->alcancecontrato,
            'fechainiciocontrato'=>$request->fechainiciocontrato,
            'duracionproyecto_contrato'=>$request->duracionproyecto_contrato,
                   

        ]);
       
        
        ProjectController::havedocuments($request,'contratacion');
    


        if($procedimiento_contratacion){
            DB::table('project')
            ->where('id',$request->id_project)
            ->update(['status'=>3]);

            return redirect()->route('project.ejecucion',[
                'project'=>$request->id_project,
                ]);;
        }else{
           
        }

    }

    public function savepreparacion(Request $request){
       
        $fecha_in = date('Y-m-d');
        
        $request->validate([
            'tipoAmbiental'=>'required',
        'fecharealizacionAmbiental'=>'required|max:50',
        'responsableAmbiental'=>'required|max:255',
        'numeros_ambiental'=>'required',
            
            'tipoFactibilidad'=>'required',
        'fecharealizacionFactibilidad'=>'required|max:50',
        'responsableFactibilidad'=>'required|max:255',
        'numeros_factibilidad'=>'required',

        'tipoImpacto'=>'required',
        'fecharealizacionImpacto'=>'required|max:50',
        'responsableImpacto'=>'required|max:255',
        'numeros_impacto'=>'required',

        'origenrecurso'=>'required',
        'fuenterecurso'=>'required|max:255',
        'fecharecurso'=>'required|max:50'
        
        ]);
      
      

        DB::table('estudiosambiental')->insert([
            'id_project'=>$request->id_project,
            'descripcionAmbiental'=>$request->descripcionAmbiental,
            'tipoAmbiental'=>$request->tipoAmbiental,
            'fecharealizacionAmbiental'=>$request->fecharealizacionAmbiental,
            'responsableAmbiental'=>$request->responsableAmbiental,
            'numeros_ambiental'=>$request->numeros_ambiental,
        ]);

        DB::table('estudiosfactibilidad')->insert([
            'id_project'=>$request->id_project,
            'descripcionFactibilidad'=>$request->descripcionFactibilidad,
            'tipoFactibilidad'=>$request->tipoFactibilidad,
            'fecharealizacionFactibilidad'=>$request->fecharealizacionFactibilidad,
            'responsableFactibilidad'=>$request->responsableFactibilidad,
            'numeros_factibilidad'=>$request->numeros_factibilidad,
        ]);
        DB::table('estudiosimpacto')->insert([
            'id_project'=>$request->id_project,
            'descripcionImpacto'=>$request->descripcionImpacto,
            'tipoImpacto'=>$request->tipoImpacto,
            'fecharealizacionImpacto'=>$request->fecharealizacionImpacto,
            'responsableImpacto'=>$request->responsableImpacto,
            'numeros_impacto'=>$request->numeros_impacto,
        ]);

        DB::table('project')
        ->where('id',$request->id_project)
        ->update(['status'=>2]);

       
        

      
        $presupuesto=new BudgetBreakdown();
        $presupuesto->description=$request->origenrecurso;
        $presupuesto->sourceParty_name=$request->fuenterecurso;
       
        
        $period=new Period();
        $period->startDate=$request->fecharecurso;
        $period->save();

        $presupuesto->id_period=$period->id;
        $presupuesto->save();

        DB::table('project_budgetbreakdown')
        ->insert([

            'id_project'=>$request->id_project,
            'id_budget'=>$presupuesto->id,
        ]);


        //Guardar el documento y la relación con su proyecto.
 

        if(!empty($request->documents)){
            
            for ($i=0; $i <sizeof($request->documents) ; $i++) { 
                $nombre_img = $_FILES['documents']['name'][$i];
    
                move_uploaded_file($_FILES['documents']['tmp_name'][$i],'documents/'.$nombre_img);
                $url=$nombre_img;
        
               
                
        
                $documents=new Documents();
                $documents->documentType=1;
                $documents->description="preparacion";
                $documents->url=$url;
                $documents->save();
        
                $projectdocuments=new ProjectDocuments();
                $projectdocuments->id_project=$request->id_project;
                $projectdocuments->id_document=$documents->id;
                $projectdocuments->save();
                }


            }

           

        return redirect()->route('project.contratacion',[
        'project'=>$request->id_project,
        ]);;
       



    }
     
    public function saveidentificacion(Request $request){
        
        $fecha_in = date('Y-m-d');
        
        $request->validate([
          
            'tituloProyecto'=>'required|max:255',
            'ocid'=>'required|max:50',
            'descripcionProyecto'=>'required|max:255',
            'autoridadP'=>'required|max:50',
            'propositoProyecto'=>'required|max:50',
            'sectorProyecto'=>'required|max:50',
            'subsector'=>'required|max:50',
            'tipoProyecto'=>'required|max:50',
            'people'=>'required|max:50',

            'streetAddress'=>'required|max:50',
            'locality'=>'required|max:50',
            'region'=>'required|max:50',
            'postalCode'=>'required|max:50',
            'countryName'=>'required|max:50',
            'description'=>'required|max:50'

        ]);
    
            
        $project = Project::find($request->id_project);
     
        $project->ocid = $request->ocid;
        $project->updated = $fecha_in;
        $project->title = $request->tituloProyecto;
        $project->description = $request->descripcionProyecto;
        $project->status = 1;
       
        $project->sector = $request->sectorProyecto;
        $project->subsector=$request->subsector;
        $project->purpose = $request->propositoProyecto;
        $project->type = $request->tipoProyecto;
        $project->people = $request->people;
        
      
        $project->publicAuthority_name = '';
        $project->publicAuthority_id = $request->autoridadP;
        
       

        $project->save();
               

        DB::table('project_organizations')->insert([

            'id_project'=>$project->id,
            'id_organization'=>$request->autoridadP,
        ]
        );

        $address = new Address();
        $address->streetAddress = $request->streetAddress;
        $address->locality = $request->locality;
        $address->region = $request->region;
        $address->postalCode = $request->postalCode;
        $address->countryName = $request->countryName;
        $address->save();


        $locations = new Locations();
        $locations->description = $request->description;
        $locations->id_geometry = 1;
        $locations->id_gazetter = 1;
        $locations->id_address = $address->id;
        $locations->lat = $request->lat;
        $locations->lng = $request->lng;
        $locations->save();




        $project_locations = new ProjectLocations();
        $project_locations->id_project = $project->id;
        $project_locations->id_location = $locations->id;
        $project_locations->save();

       


        //Guardar el documento y la relación con su proyecto.
        if(!empty($request->docfase1)){    
            
         

            for ($i=0; $i < sizeof($request->docfase1); $i++) { 
                $nombre_img = $_FILES['docfase1']['name'][$i];

                move_uploaded_file($_FILES['docfase1']['tmp_name'][$i],'documents/'.$nombre_img);
                $url=$nombre_img;
        
               
                
        
                $documents=new Documents();
                $documents->documentType=$request->documenttype;
                $documents->description="identificacion";
                $documents->url=$url;
                $documents->save();
        
                $projectdocuments=new ProjectDocuments();
                $projectdocuments->id_project=$project->id;
                $projectdocuments->id_document=$documents->id;
                $projectdocuments->save();

            }
            
     
        }
        

     
      
     return redirect()->route('project.preparacion',['project'=>$project->id]);;
       
    }


    public function store(Request $request)
    {
        //

       

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    public function destroy($id)
    {
        //

    
        $project = Project::find($id);

         //to unlink projects imgs

         $projects_imgs=DB::table('projects_imgs')
         ->where('id_project','=',$project->id)
         ->get();
        
 
         foreach($projects_imgs as $project_img){
             $ruta='projects_imgs/'.$project_img->imgroute;
             if(file_exists(($ruta))){
                unlink($ruta);
             }
             
             
         }
 
        
        
       

        if(!empty($project))
        {       

         
        //Para eliminar los documentos asociados al proyecto.
        $project_documents=ProjectDocuments::where('id_project','=',$id)
        ->get();
        foreach ($project_documents as $document) {
           
            Documents::destroy($document->id);
        }

       
    
        //Para eliminar la ubicación del proyecto.
        $project_locations = ProjectLocations::where('id_project','=',$id)
        ->first();

        if($project_locations!=null){
            $locations = Locations::find($project_locations->id_location);

            Address::destroy($locations->id_address);
        }

        
             
       

        $project_budget=DB::table('project')
        ->join('project_budgetbreakdown','project.id','=','project_budgetbreakdown.id_project')
        ->select('project_budgetbreakdown.id_budget')
        ->where('project.id','=',$id)
        ->first();

        if($project_budget!=null){
            BudgetBreakdown::destroy($project_budget->id_budget);
        }
       
        
       
       
        Project::destroy($id);
       
     
        return back()->with('status', '¡Proyecto eliminado con éxito!');
        }
        else
        {     
            return back()->with('status', '¡Proyecto no encontrado!');
           
        }
      

    }
    public function deletedocument(Request $request){
        
            
         $document=Documents::find($request->doc_id);
              
        $url=public_path().'/documents'.'/'.$document->url;
     


       unlink($url);
       $document->delete();
       return back()->with('status', '¡Documento eliminado!');
    }
    public static function havedocuments(Request $request,$fase){
        
        
        if(!empty($request->documents)){
            
            for ($i=0; $i <sizeof($request->documents) ; $i++) { 
                $nombre_img = $_FILES['documents']['name'][$i];
    
                move_uploaded_file($_FILES['documents']['tmp_name'][$i],'documents/'.$nombre_img);
                $url=$nombre_img;
        
               
                
        
                $documents=new Documents();
                $documents->documentType=1;
                $documents->description=$fase;
                $documents->url=$url;
                $documents->save();
        
                $projectdocuments=new ProjectDocuments();
                $projectdocuments->id_project=$request->id_project;
                $projectdocuments->id_document=$documents->id;
                $projectdocuments->save();
                }
            }

            
    }
    
    public function testmap(){
                return view('admin.testmap');
    }
    public function tm(){
      

        return view('admin.testmap',[
            'datos'=>$_POST,
        ]);
    }
}

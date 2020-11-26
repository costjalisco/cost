
    <div class="col-lg-6">

        <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#collapseCardExample5" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample5">

                <h6 class="m-0 font-weight-bold text-primary">Documentos</h6>
            </a>
            <!-- Card Content - Collapse -->

            <div class="collapse show" id="collapseCardExample5">
                <div class="card-body">

                    <form>


                        <div class="form-row">
                            <div class="form-group">
                                <label for="">Seleccionar documentos</label>
                                <input type="file" class="form-control" name="documents[]" multiple>

                                @if(sizeof($documents)!=0)
                                <br>
                                <label for="">Lista de documentos</label>


                                <div class="col-md-12">

                                    <table class="table table-sm">
                                        <tr>
                                            <th>Nombre del documento</th>
                                            <th>Acciones</th>
                                        </tr>


                                        <tbody>
                                            @foreach($documents as $document)
                                            <?php
                                            $ruta = 'documents/' . $document->url;

                                            ?>


                                            <tr>
                                                <td>
                                                    <a target="_blank" class="badge badge-pill badge-info" href="{{asset($ruta)}}">{{$document->url}}</a>
                                                </td>

                                                <td>

                                                    <a id="deldoc" href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteUserModal" data-id="{{ $document->id }}" data-name="{{ $document->url }}">
                                                        <i class="fa fa-trash"></i>
                                                    </a>


                                                </td>
                                            </tr>

                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                                @endif

                            </div>



                        </div>
                </div>


            </div>
        </div>
      
      
</div>

         <div class="container">          
           <div class="modal" id="miModalCFaltantes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document" style="z-index: 9999; width: 470px">
                    <div class="modal-content">
                        <div class="modal-header">                            
                            <h4 class="modal-title" id="myModalLabel">Seleccionar cuenta</h4>
                        </div>
                        <div class="modal-body">
                          
                               <form name="formCF" id="formCF" action="" method="post">
                                <input type="hidden" name="if" id="if" value="">
                                <div class="panel-body" id="formCFaltante">
                                   
                       

                                </div>
                            </form>
                             <button type="button" class="btn-flip btn btn-gradient btn-info" data-dismiss="modal">Cerrar</button>
                      </div>
                    </div>                    
                </div>
            </div>
              
              <!--inventario para cierre-->        
           <div class="modal" id="miModalInventario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document" style="z-index: 9999; width: 470px">
                    <div class="modal-content">
                        <div class="modal-header">                            
                            <h4 class="modal-title" id="myModalLabel">Ingrese Inventario Final</h4>
                        </div>
                        <div class="modal-body">
                          
                               
                               
                                <div class="panel-body" id="formCFaltante">
                                    <label>Inventario final</label>
                                   <input type="number" name="if" id="if" min="0">

                                    <button type="button" onclick="onProcesar();" class="btn-flip btn btn-gradient btn-primary">
                              
                                <div class="side">
                                 Aceptar<span class="fa"></span>
                                </div>
                               
                             
                             
                            </button>
                        
                                </div>
                                <button type="button" class="btn-flip btn btn-gradient btn-info" data-dismiss="modal">Cerrar</button>
                          
                      </div>
                    </div>                    
                </div>
            </div>
 <!--inventario para estado-->  
            <div class="modal" id="miModalInventarioE" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document" style="z-index: 9999; width: 470px">
                    <div class="modal-content">
                        <div class="modal-header">                            
                            <h4 class="modal-title" id="myModalLabel">Ingrese Inventario Final</h4>
                        </div>
                        <div class="modal-body">
                          
                               
                               
                                <div class="panel-body" id="formCFaltante">
                                    <label>Inventario final</label>
                                   <input type="number" name="ifE" id="ifE" min="0">

                                    <button type="button" onclick="onEstado();" class="btn-flip btn btn-gradient btn-primary">
                              
                                <div class="side">
                                 Aceptar<span class="fa"></span>
                                </div>
                               
                             
                             
                            </button>
                        
                                </div>
                                <button type="button" class="btn-flip btn btn-gradient btn-info" data-dismiss="modal">Cerrar</button>
                          
                      </div>
                    </div>                    
                </div>
            </div>

             <!--inventario para balance-->  
            <div class="modal" id="miModalInventarioB" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document" style="z-index: 9999; width: 470px">
                    <div class="modal-content">
                        <div class="modal-header">                            
                            <h4 class="modal-title" id="myModalLabel">Ingrese Inventario Final</h4>
                        </div>
                        <div class="modal-body">
                          
                               
                               
                                <div class="panel-body" id="formCFaltante">
                                    <label>Inventario final</label>
                                   <input type="number" name="ifB" id="ifB" min="0">

                                    <button type="button" onclick="onBalance();" class="btn-flip btn btn-gradient btn-primary">
                              
                                <div class="side">
                                 Aceptar<span class="fa"></span>
                                </div>
                               
                             
                             
                            </button>
                        
                                </div>
                                <button type="button" class="btn-flip btn btn-gradient btn-info" data-dismiss="modal">Cerrar</button>
                          
                      </div>
                    </div>                    
                </div>
            </div>

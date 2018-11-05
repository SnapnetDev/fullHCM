 <div class="modal fade modal-super-scaled" id="addkpi" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="modaltitle">Add KPI</h4>
                        </div>
                        <div class="modal-body">
                        <form id="kpiform">
                          <table class="table table-striped">

                                <tr>
                                    <td> Deliverable<br></td>
                                    <td> <textarea required class="form-control" rows="3" id="deliverables" ></textarea></td>

                                </tr>
                                 <tr>
                                    <td>Target Weight</td>
                                    <td> <input required type="number" min="0"  id="targetweight" class="form-control"></td>

                                </tr>
                                <tr>
                                    <td>Target Amount</td>
                                    <td> <input required type="number" min="0"   id="targetamount" class="form-control"></td>

                                </tr>
                                 <tr>
                                    <td>Comment</td>
                                    <td><textarea required="" class="form-control" rows="3" id="comment" ></textarea></td>

                                </tr> 
                
                                 <tr>
                                <td>Duration</td>
                                <td>
                                   From &nbsp;<input class="form-control" name="start" type="" readonly="" data-plugin="datepicker" id="froms">  &nbsp;to &nbsp;
                                   <input name="end" type="" class="form-control" readonly="" data-plugin="datepicker" id="tos">
                                </td>

                                </tr>
                          </table>
                          
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary" id="addbtn">Add Kpi</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
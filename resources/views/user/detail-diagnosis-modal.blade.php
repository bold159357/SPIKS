<div class="modal fade placeholder-glow" id="detailDiagnosisModal">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title h4 placeholder">Detail Diagnosis</h1>
                <button type="button" class="btn-close placeholder" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <h1 id="headerDetailDiagnosis" class="font-semibold placeholder text-center pt-5 d-none">
                    </h1>
                    <p id="subheaderDetailDiagnosis" class="h3 placeholder font-normal text-center d-none">
                    </p>
                    <p id="tidakditemukan" class="h6 placeholder font-normal text-center d-none">
                    </p>
                    <div class="row pt-5" id="rowDetailkepribadian">
                        <div class="col-12 ">
                            <h2 class="font-semibold pb-3 placeholder">
                                Detail kepribadian
                            </h2>
                            <div class="card border border-0  shadow">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-lg-8 pt-5 pt-lg-0 order-1">
                                            <div class="pb-3">
                                                <h3 class="h4 placeholder">Nama kepribadian</h3>
                                                <p class="card-text placeholder" id="kepribadianName">
                                                </p>
                                            </div>
                                            <div class="pb-3">
                                                <h3 class="h4 placeholder">Ciri ciri kepribadian</h3>
                                                <p class="card-text placeholder" id="kepribadianReason">
                                                </p>
                                            </div>
                                            <div>
                                                <h3 id="headerkepribadianSolution" class="h4 placeholder">Solusi kepribadian
                                                </h3>
                                            </div>
                                        </div>
                                        
                                        <div
                                            class="col-12 col-lg-4 order-lg-2 d-flex align-items-center justify-content-center placeholder">
                                            <div class="container-image-kepribadian"
                                                id="containerImagekepribadianDetailDiagnosisModal"
                                                style="max-width: 0px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row py-5 ">
                        <h2 class="font-semibold pb-3 placeholder">
                            Histori Jawaban
                        </h2>
                        <div class="card border border-0 shadow" style="max-height: 400px; overflow-y: scroll">
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table class="table table-striped placeholder" id="detailJawabanDiagnosisTable">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">indikasi</th>
                                                <th scope="col">Bobot</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-group-divider">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row pb-5 ">
                        <h2 class="font-semibold pb-3 placeholder">
                         Persentase kepribadian </h2>
                        <div class="card border border-0 shadow">
                        <div class="card-body placeholder">
                        <canvas id="chartDiagnosiskepribadian" height="300"></canvas>
                        </div>
                         </div>
                        </div>
                </div>
              
            </div>
        </div>
    </div>
</div>

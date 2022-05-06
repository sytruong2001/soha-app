@extends('layouts.layoutUser')
@section('content')
    <div class="main main-raised">
        <div class="profile-content">
            <div class="container">
                <div class="tab-content">
                    <div class="tab-pane active work" id="work">
                        <div class="row">
                            <div class="col-md-3">
                                <h4 class="title"><img src="../img/faces/christian.jpg" alt="Circle Image"
                                        class="img-circle img-responsive img-raised" width="60px">
                                </h4>
                                <ul class="list-unstyled" id="list-option">

                                </ul>

                            </div>
                            <div class="col-md-6" id="title-option">

                            </div>
                            <div id="id01" class="w3-modal">
                                <div class="w3-modal-content">
                                    <div class="w3-container">
                                        <div class="row">
                                            <span onclick="document.getElementById('id01').style.display='none'"
                                                class="w3-button w3-display-topright">&times;</span>
                                            <p id="title-submit"></p>
                                        </div>
                                        <div class="row">
                                            <div class="fresh-datatables">
                                                <table id="datatable_history"
                                                    class="table table-striped table-no-bordered table-hover"
                                                    cellspacing="0" width="100%" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Mã giao dịch</th>
                                                            <th>Số lượng</th>
                                                            <th>Thời gian</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Mã giao dịch</th>
                                                            <th>Số lượng</th>
                                                            <th>Thời gian</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody id="body-history">

                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script language="javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
    <script src="js/ID-user.js"></script>
@endsection

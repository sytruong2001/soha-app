@extends('layouts.layoutUser')
@section('content')
    <div class="main main-raised">
        <div class="profile-content" style="min-height: 500px">
            <div class="container">
                <div class="tab-content">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8"><img alt=""
                                src="https://ssg.mediacdn.vn/soap/2022/03/16467099811_1920x466_optimized.jpg" width="100%">
                        </div>
                        <div class="col-md-2"></div>

                    </div>

                    <div class="row">
                        <div class="col-md-12 col-md-offset-1" id="payment-account">

                        </div>

                    </div>
                    <div id="id01" class="w3-modal">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                                    <span onclick="document.getElementById('id01').style.display='none'"
                                        class="w3-button w3-display-topright">&times;</span>
                                </div>
                                <div class="modal-body">
                                    <div class="content">

                                    </div>
                                </div>

                                <div class="modal-footer">

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
    <script src="js/payment.js"></script>
@endsection

<!--Modal za wishlist-->
<div class="container">
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" id="table-div"></div>
        </div>
    </div>
</div>


<!--Modal za biografiju-->
<div class="container">
    <div class="modal fade" id="myModal1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="position:relative">
                    <button type="button" class="close" data-dismiss="modal" onclick="reset()"
                            style="position: absolute; top: 10px; right:10px">&times;
                    </button>
                    <h4 class="left modal-title" id="author-name-surname"></h4>
                </div>

                <div class="modal-body" id="more-info-results">
                    <div class="data-not-found" style="display: none;">Sorry, no additional information found.</div>
                    <div class="data">Sorry, no additional information found.</div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-yellow btn-default get-pdf-class" id="get-pdf" value=""
                            style="display: none;" onclick="get_pdf(this)">Get whole data in PDF format
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="reset()">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Modal za more books-->
<div class="container" id="show-this">
    <div class="modal fade" id="myModal2" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" id="more-books"></div>
        </div>
    </div>
</div>

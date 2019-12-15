<div class="modal fade" id="suggestNewCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content mdl-subs">
			<div class="modal-header mdl-hdr">
				<h5 class="modal-title prmte" id="exampleModalLabel">Suggest a New Category</h5>
				<button type="button" class="close mdl-clse" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="">
				<div class="modal-body pop_sngle_prjct mdl-body"> 
					<div class="sugestNewCat">
						<div class="NewCatItem">
							<span>To: </span><p>hello@livewire.work</p>
						</div>
						<div class="NewCatItem">
							<span>Subject: </span><h5>Category Suggestion</h5>
						</div>
						<div class="suggestMsgBox">
							<textarea class="form-control" rows="8" placeholder="Type Message"></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer mdl-ftr">
					<div class="form-group text-right pay-btn">
						<a href="javascript:void(0)" class="lve-wre-btn clr-proprty pop-btn mt-10 forgot_password">Send</a>
						<a href="javascript:void(0)" data-dismiss="modal" class="cls-txt">Close</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<style type="text/css">
	.NewCatItem * {
    margin: 0;
    padding: 0;
}

.NewCatItem {
    display: inline-flex;
    width: 100%;
    align-items: center;
    margin-bottom: 20px;
    border-bottom: 1px solid #ccc;
    padding-bottom: 20px;
    font-size: 15px;
}
.NewCatItem span {
    margin-right: 10px;
    color: #828282;
}
.NewCatItem p {
    color: #049a43;
}
.NewCatItem h5 {
    font-size: 16px;
    text-transform: uppercase;
}
.suggestMsgBox textarea {
    border: none;
    border-bottom: 1px solid #ccc;
    font-size: 16px;
    padding: 0;
}
</style>

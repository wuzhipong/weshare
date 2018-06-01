 $('.delete').click(function(){
	openModal("modelDelete.html");
	closeModal();
});

$('.details').click(function(){
	openModal("modelDetails.html");
	closeModal();
});

$('.modify').click(function(){
	openModal("userModifymodel.html");
	closeModal();
});
//打开模态框
function openModal(str){
    var fatherBody = $(window.top.document.body);
    var id = 'pages';
    var dialog = $('#' + id);
    if (dialog.length == 0) {
        dialog = $('<div class="modal fade" role="dialog" id="' + id + '"/>');
        dialog.appendTo(fatherBody);
    }
    dialog.load(str, function() {
        dialog.modal({
          backdrop: false
        });
    });
    fatherBody.append("<div id='backdropId' class='modal-backdrop fade in'></div>");
}

//关闭模态框
function closeModal(){
    var fatherBody = $(window.top.document.body);
    fatherBody.find("#pages").on('hidden.bs.modal', function (e) {
        fatherBody.find("#backdropId").remove();
        fatherBody.find("#pages").remove();
    });
}
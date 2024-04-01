function delete_confirm(){
    if($('.checkbox:checked').length > 0){
        var result = confirm("Are you sure to delete selected users?");
        if(result){
            return true;
        }else{
            return false;
        }
    }else{
        alert('Select at least 1 record to delete.');
        return false;
    }
}
        $(document).ready(function(){
    $('#select_all').on('click',function(){
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
            $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length){
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }
    });
});

function disable(id){
    if ($('#'+id).prop("checked") === true) {
        $('.'+id).css({
        'text-decoration': 'none',  
        'color':'gray'
      })
    }
    else{
        $('.'+id).css({
            'text-decoration': 'none',  
            'color':'darkblue'
          })
    }
$('.'+id).click(function(e) {
    //alert(id);
    if ($('#'+id).prop("checked") === true) {
      e.preventDefault();
     
      return false;
    } else {
       
      return true;
    }
  });
  
}

//   function disable(id){
//     alert(id);
//     $('#'+id).click(function(event){
//         event.preventDefault();
//     });
//     document.getElementById("demo").innerHTML=id;
//     document.getElementById("links").attr("disabled","disabled");
//     // $('#id').attr("disabled","disabled");
//   }
  

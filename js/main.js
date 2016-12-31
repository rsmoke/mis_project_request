$(function () {
  if ($( 'body' ).has($('#short_description'))) {
    input_counter('short_description');
  }

  $('#contact_uniqname').blur( function(e){
    var get_uniq = $('#contact_uniqname').val();
    $.post("ldapglean.php", {lookup_uniq: get_uniq })
    .done(function( data ) {
      var json = $.parseJSON( data );
      if ( json[0] == "empty"){

        // alert ("Enter a valid uniqname");
        $('#contact_uniqname').val("Enter a valid uniqname");
        $('#contact_first_name').val("");
        $('#contact_last_name').val("");
        $('#contact_email').val("");
        $('#contact_department').val("");
        $('#contact_uniqname').focus();
      } else {
        $('#contact_first_name').val(json.first_name);
        $('#contact_last_name').val(json.last_name);
        $('#contact_email').val(get_uniq + "@umich.edu");
        $('#contact_department').val(json.department);
      }
    });
  });

});

function input_counter(input_box){
  var count = $('#'+ input_box).val().length;
  var max = 140;
  $('#statusArea').text('Use less than ' + max + ' characters.');

  $('#'+ input_box).keyup( function(){
      count = $('#'+ input_box).val().length;
      $('#statusArea').empty();
      $('#statusArea').text((max - count) + ' characters left.');
      if (count >= 150) {
          $('#'+ input_box).prop('disabled', true);
      }
  }).change();

  $('#'+ input_box).keypress(function(e) {
      if (e.which < 0x20) {
          // e.which < 0x20, then it's not a printable character
          // e.which === 0 - Not a character
          return;     // Do nothing
      }
      if (this.value.length == max) {
          e.preventDefault();
      } else if (this.value.length > max) {
          // Maximum exceeded
          this.value = this.value.substring(0, max);
      }
  });
}

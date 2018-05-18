/**
 * Created by kostas on 25/3/2018.
 */
$('select').change( function () {
  if ($(this).val() === 'new') {
    $(this).replaceWith('<input class="input is-medium has-icons-left" type="text" name="'+$(this).attr('name')+'" id="'+$(this).attr('id')+'">');
  }
});

$('#user-id').find('option').mousedown(function(e) {
  e.preventDefault();
  $(this).prop('selected', !$(this).prop('selected'));
  return false;
});
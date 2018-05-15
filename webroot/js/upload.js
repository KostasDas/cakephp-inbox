/**
 * Created by kostas on 15/5/2018.
 */

var input = document.getElementById( 'file-upload-input' );
var infoArea = document.getElementById( 'file-upload-name' );

input.addEventListener( 'change', showFileName );

function showFileName( event ) {

  var input = event.srcElement;

  var fileName = input.files[0].name;

  infoArea.textContent = fileName;
}
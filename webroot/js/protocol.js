/**
 * Created by kostas on 9/5/2018.
 */
var sender = $('#s_sender');
var type = $('#s_type');
var topic = $('#s_topic');
var number = $('#s_number');
var protocol = $('#s_protocol');
var created = $('#s_created');
var user = $('#s_user');
var before = $('#s_created_before');
var after = $('#s_created_after');
var fileType = $('#s_file_type');

// REMOVES TEXT SELECTION
function clearSelection() {
  if (document.selection && document.selection.empty) {
    document.selection.empty();
  } else if (window.getSelection) {
    var sel = window.getSelection();
    sel.removeAllRanges();
  }
}


function getFiles(filters) {

  $.ajax({
    // cache: false,
    type: "GET",
    url: "/hawk-files",
    data: filters,
    dataType: "json"
  }).done(function (response) {
    var protocolTable = $('#protocolTable');

    jQuery.fn.dataTableExt.oSort["custom-desc"] = function (x, y) {
      return y.localeCompare(x);
    };

    jQuery.fn.dataTableExt.oSort["custom-asc"] = function (x, y) {
      return x.localeCompare(y);
    };
    var user = response.authUser;

    // EMPTY AND REFILL DATATABLE
    protocolTable.dataTable({
      data: response.files,
      responsive: true,
      "autoWidth": false,
      "deferRender": true,
      "destroy": true,
      "sort": true,
      select: {
        style: 'multi',
        selector: 'td:not(:last-child)'
      },
      "aoColumnDefs": [{
        "sType": "custom",
        "bSortable": true,
        "aTargets": [1]
      }],
      language: {
        "lengthMenu": "Δείξε _MENU_ αποτελέσματα",
        "search": "Ελεύθερη αναζήτηση κειμένου:",
        "searchPlaceholder": "Θέμα, Αποστολέας, Φ/SIC",
        "paginate": {
          "previous": "Προηγούμενη σελίδα",
          "next": "Επόμενη σελίδα"
        },
        "zeroRecords": "Δε βρέθηκαν αποτελέσματα",
        "info": "Αποτελέσματα _START_ εώς _END_  από _TOTAL_"
      },
      "columns": [{
        title: "id",
        "data": "id",
        "visible": false,
        "searchable": false
      }, {
        title: "Αριθμός Ταυτότητας",
        "data": "number"
      }, {
        title: "Είδος Αλληλογραφίας",
        "data": "type"
      }, {
        title: "Τύπος Αρχείου",
        "data": "file_type"
      }, {
        title: "Θέμα/Περίληψη",
        "data": "topic"
      }, {
        title: "Αποστολέας",
        "data": "sender"
      }, {
        title: 'Φ/SIC',
        "data": 'protocol'
      }, {
        title: 'Αποθηκεύτηκε',
        "data": 'created',
        "render": function (data, type, full) {
          return formatDate(data);
        }
      },{
        title: 'Χειριστές',
        "data": 'users',
        "render": function (data, type, full) {
          var users = '';
          $.each(data, function (key, value) {
            users += value.name + '</br>';
          });
          return users;
        }
      },
        {
          title: "Ενέργειες",
          "data": "id",
          "orderable": false,
          "searchable": false,
          "sClass": 'options text-center',
          "render": function (data, type, full) {

            var links = '<div><a class="h3 well-sm" href=/hawk-files/download/' + data + '><span data-toggle="tooltip" title="Λήψη" class="icon"> <i class="fas fa-arrow-down"></i></span></a>' +
              '<a class="h3 well-sm" target="_blank" href=/hawk-files/view/' + data + '><span data-toggle="tooltip" title="Προβολή" class="icon"><i class="fas fa-eye"></i></span></a>';
            if (user) {
              links += '<a class="h3 well-sm" href=/hawk-files/inboxEdit/' + data + '><span data-toggle="tooltip" title="Επεξεργασία" class="icon"><i class="fas fa-edit"></i> </span></a></div>';
            }
            return links;
          }
        }],
      "columnDefs": [
        {responsivePriority: 1, targets: 20},
        {responsivePriority: 2, targets: 1},
        {responsivePriority: 2, targets: 2}
      ],
      dom: "<'columns'<'column'l><'column'f>>" +
      "<'columns'<'column'tr>>" +
      "<'columns'<'column'i><'column'p>>"
    });
  });

}


function filter() {
  var filters = {};

  // CHECKING FILTERS
  if (sender.val() !== '')
    filters.sender = sender.val();

  if (type.val() !== '')
    filters.type = type.val();

  if (fileType.val() !== '')
    filters.fileType = type.val();

  if (topic.val() !== '')
    filters.topic = topic.val();

  if (number.val() !== '')
    filters.number = number.val();

  if (protocol.val() !== '')
    filters.protocol = protocol.val();

  if (created.val() !== '')
    filters.created = created.val();

  if (user.val() !== '')
    filters.user = user.val();

  if (before.val() !== '')
    filters.before = before.val();

  if (after.val() !== '')
    filters.after = after.val();
  // FILTER DATATABLE RESULTS
  getFiles(filters);
}


function fillTypes() {
  $.ajax({
    // cache: false,
    type: "GET",
    url: "/hawk-files/types",
    dataType: "json"
  }).done(function (response) {

    $.each(response.types, function (index, element) {
      type.append($("<option></option>")
        .val(element.type)
        .text(element.type));
    });

    type.on('change', function () {
      filter();
    });
  });
}

function fillSenders() {
  $.ajax({
    // cache: false,
    type: "GET",
    url: "/hawk-files/senders",
    dataType: "json"
  }).done(function (response) {

    $.each(response.senders, function (index, element) {
      sender.append($("<option></option>")
        .val(element.sender)
        .text(element.sender));
    });

    sender.on('change', function () {
      filter();
    });
  });
}

function fillUsers() {
  $.ajax({
    // cache: false,
    type: "GET",
    url: "/users",
    dataType: "json"
  }).done(function (response) {

    $.each(response.users, function (index, element) {
      user.append($("<option></option>")
        .val(element.id)
        .text(element.name));
    });

    user.on('change', function () {
      filter();
    });
  });
}

$(document).ready(function () {

  fillTypes();
  fillSenders();
  fillUsers();

  $('#s_number, #s_protocol, #s_topic, #s_protocol').on('keyup', function () {
    filter();
  });
  $('#s_created_before, #s_created_after').on('change', function () {
    filter();
  });

  getFiles(null);
});
/**
 * Created by kostas on 29/4/2018.
 */

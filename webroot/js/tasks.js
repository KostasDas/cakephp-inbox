/**
 * Created by kostas on 9/5/2018.
 */
var user = $('#s_user');
var done = $('#s_done');
var is_read = $('#s_read');
var due = $('#s_due');


function getTasks(filters) {

  $.ajax({
    // cache: false,
    type: "GET",
    url: "/tasks",
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
    var logged = response.authUser;

    // EMPTY AND REFILL DATATABLE
    protocolTable.dataTable({
      data: response.tasks,
      responsive: true,
      "autoWidth": false,
      "deferRender": true,
      "destroy": true,
      "sort": true,
      "order": [[5, "asc"]],
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
      },{
        title: "Τιτλος Αρχείου",
        "data": "hawk_file.topic"
      }, {
        title: "Περιγραφη",
        "data": "description"
      }, {
        title: 'Χειριστής',
        "data": 'user.name'
      }, {
        title: 'Δημιουργός',
        "data": 'owner.name'
      },{
        title: 'Προθεσμία',
        "data": 'due',
        "render": function (data, type, full) {
          if (data) {
            return formatDate(data);
          }
          return 'Δεν έχει οριστεί';
        }
      },
        {
          title: "Ενέργειες",
          "data": {
          },
          "orderable": false,
          "searchable": false,
          "sClass": 'options text-center',
          "render": function (data) {
            var read_icon = data.is_read ? 'fas fa-envelope-open' : 'fas fa-envelope';
            var read_title = data.is_read ? 'Σημείωση ως αδιάβαστη ενέργεια' : 'Σημείωση ως διαβασμένη ενέργεια';
            var done_icon = data.done ? 'fas fa-times-circle' : 'fas fa-play';
            var done_title = data.done ? 'Σημείωση ως ενεργή ενέργεια' : 'Σημείωση ως ολοκληρωμενη ενέργεια';
            var links = '<div><a class="h3 well-sm" href=/tasks/read/' + data.id + '><span data-toggle="tooltip" title="'+read_title+'" class="icon"> <i class="'+read_icon+'"></i></span></a>';
            links += '<a class="h3 well-sm" href=/tasks/do/' + data.id + '><span data-toggle="tooltip" title="'+done_title+'" class="icon"> <i class="'+done_icon+'"></i></span></a>';
            if (logged.role == 'admin') {
              links += '<a class="h3 well-sm" href=/tasks/edit/' + data.id + '><span data-toggle="tooltip" title="Επεξεργασία" class="icon"><i class="fas fa-edit"></i> </span></a></div>';
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
  if (user.val() !== '')
    filters.user = user.val();

  if (due.val() !== '')
    filters.due = due.val();

  if (is_read.val() !== '')
    filters.is_read = is_read.val();

  if (done.val() !== '')
    filters.done = done.val();
  // FILTER DATATABLE RESULTS
  getTasks(filters);
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
  });
}

$(document).ready(function () {

  fillUsers();

  $('#s_due, #s_user, #s_read, #s_done').on('change', function () {
    filter();
  });

  getTasks(null);
});
/**
 * Created by kostas on 29/4/2018.
 */

function formatDate(dateString) {
    var date = new Date(dateString);

    var dd = date.getDate();
    var mm = date.getMonth() + 1;
    var yyyy = date.getFullYear();

    dd = fillZeroes(dd);
    mm = fillZeroes(mm);

    return dd + '/' + mm + '/' + yyyy;
}

function fillZeroes(data) {
    if (data < 10) {
        data = '0' + data;
    }

    return data;
}
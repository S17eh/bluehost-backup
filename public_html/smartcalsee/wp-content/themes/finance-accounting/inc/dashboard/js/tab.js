function finance_accounting_openCity(evt, cityName) {
    var finance_accounting_i, finance_accounting_tabcontent, finance_accounting_tablinks;
    finance_accounting_tabcontent = document.getElementsByClassName("tabcontent");
    for (finance_accounting_i = 0; finance_accounting_i < finance_accounting_tabcontent.length; finance_accounting_i++) {
        finance_accounting_tabcontent[finance_accounting_i].style.display = "none";
    }
    finance_accounting_tablinks = document.getElementsByClassName("tablinks");
    for (finance_accounting_i = 0; finance_accounting_i < finance_accounting_tablinks.length; finance_accounting_i++) {
        finance_accounting_tablinks[finance_accounting_i].className = finance_accounting_tablinks[finance_accounting_i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}
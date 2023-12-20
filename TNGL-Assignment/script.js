function addCustomer() {
    var form = $("#addCustomerForm").serializeArray();

    $.ajax({
        type: "POST",
        url: "script.php",
        data: { action: "addCustomer", ...form },
        success: function (response) {
            alert(response);
            loadCustomerList();
            $("#addCustomerForm")[0].reset();
        },
    });
}

function deleteCustomer(customerId) {
    var confirmDelete = confirm("Are you sure you want to delete this customer?");
    
    if (confirmDelete) {
        $.ajax({
            type: "POST",
            url: "script.php",
            data: { deleteCustomerId: customerId },
            success: function (response) {
                alert(response);
                loadCustomerList();
            },
        });
    }
}

function loadCustomerList() {
    $.ajax({
        type: "GET",
        url: "script.php",
        success: function (response) {
            $("#customerList").html(response);
        },
    });
}

// Load customer list on page load
$(document).ready(function () {
    loadCustomerList();
});

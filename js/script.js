$(document).ready(function () {

    /*Insert Datepicker*/
    $(function () {
        $("#datepicker").datepicker({
            dateFormat: 'dd-mm-yy',
            onSelect: function (date) {
                /*$.ajax({
                    data: {
                        'date': date
                    },
                    type: 'POST',
                    url: 'index.php',
                    success: function (html) {
                        location.reload();
                    }
                })*/
            }
        });
        return false;
    });

    /*
    $(function () {
        $("#sortable").sortable();
        $("#sortable").disableSelection();
    });
*/

    /*
        $('#sortable').children().uniqueId().end().sortable({
            axis: 'y',
            update: function (event, ui) {
                var data = $(this).sortable('serialize');

                // POST to server using $.post or $.ajax
                $.ajax({
                    data: data,
                    type: 'POST',
                    url: 'asset/save.php',
                    success: function () {
                    }
                });
            }
        });

        $("#add_row").click(function (e) {
            e.preventDefault();
            var text = $("input[name='add_sortable']").val();
            var span = $('<span class="ui-icon ui-icon-arrowthick-2-n-s">');
            var div = $("<div class='ui-state-default'/>").append(span).append(text);
            $("#sortable").append(div);

            $("#sortable").sortable('refresh');
            $("#sortable").children().uniqueId().end();
            var data_sort = $("#sortable").sortable('toArray');
            $.ajax({
                data: {
                    elements: data_sort,
                    value: text
                },
                type: 'POST',
                url: 'asset/insert.php'
            });
            $("input[name='add_sortable']").val("");
        });
    */

    /*Add "sortable" property to the boxes*/
    $(function () {
        // Add or Remove class
        var addClass = function (jQueryElement, add) {
            // Add or remove your class according to the boolean
            if (add) {
                //Add class with : addClass from jQuery
                $(jQueryElement).addClass("over-placeholder");
            } else {
                //Remove class with : removeClass from jQuery
                $(jQueryElement).removeClass("over-placeholder");
            }
        }

        $(".sortable_list").children().uniqueId().end().sortable({
            connectWith: ".connectedSortable",
            /*dropOnEmpty: false,*/
            update: function (event, ui) {
                var data = $(this).sortable('toArray', {
                    attribute: "id"
                });
                console.log(ui.item.index());
                console.log(this);
                console.log(data);
                console.log($(this).attr('department'))
                // POST to server using $.post or $.ajax
                $.ajax({
                    data: {
                        data: data,
                        department: $(this).attr('department'),
                        date: $('#datepicker').val()
                    },
                    type: 'POST',
                    url: 'asset/save_employee.php',
                    success: function () {}
                });
            },
            placeholder: "over-placeholder",
            start: function (event, ui) {
                ui.item.toggleClass("over-placeholder");
                ui.placeholder.height(ui.helper.outerHeight());
            },
            stop: function (event, ui) {
                ui.item.toggleClass("over-placeholder");
                addClass(".sortable_list", false);
            },
            over: function (event, ui) {
                var elementsToChange = $(".ui-sortable-placeholder").parents(".sortable_list");
                addClass(elementsToChange, true);
            },
            out: function (event, ui) {
                var elementsToChange = $(".ui-sortable-placeholder").parents(".sortable_list");
                addClass(elementsToChange, false);
            }
        });
    });

    /*add new department*/
    $("#add-new-department").click(function (e) {
        e.preventDefault();
        var text = $("input[name='new-department']").val();
        if (text) {
            $.ajax({
                data: {
                    new_department: text,
                },
                type: 'POST',
                url: 'asset/add_new_department.php',
                success: function () {
                    /*location.reload();*/
                    window.location.href = "index.php";
                }
            });
        }
        $("input[name='new-department']").val("");
    })

    /*add new employee*/
    $("#form-add-new-employee").submit(function (e) {
        e.preventDefault();
        var firstname = $("input[name='new-firstname']").val();
        var surname = $("input[name='new-surname']").val();
        if (firstname && surname) {
            $.ajax({
                data: {
                    new_firstname: firstname,
                    new_surname: surname,
                },
                type: 'POST',
                url: 'asset/add_new_employee.php',
                success: function () {
                    /*location.reload();*/
                    window.location.href = "index.php";
                }
            });
        }
        $("input[name='new-firstname']").val("");
        $("input[name='new-surname']").val("");
    })

    //modal view data
    $(document).on('click', '.view-data', function () {
        var employee_id = $(this).attr("id");
        if (employee_id != '') {
            $.ajax({
                url: "asset/select.php",
                method: "POST",
                data: {
                    employee_id: employee_id
                },
                success: function (data) {
                    $('#employee_detail').html(data);
                    $('#dataModal').modal('show');
                }
            });
        }
    });

    //modal edit data
    $(document).on('click', '.edit-data', function () {
        var employee_id = $(this).attr("id");
        $.ajax({
            url: "asset/fetch.php",
            method: "POST",
            data: {
                employee_id: employee_id
            },
            dataType: "json",
            success: function (data) {
                $('#firstName').val(data.firstname);
                $('#surname').val(data.surname);
                /*$('#gender').val(data.gender);
                $('#designation').val(data.designation);
                $('#age').val(data.age);*/
                $('#employee_id').val(data.ID);
                $('#insert').val("Update");

                $('#add_data_Modal').modal('show');
            }
        });
    });

    //update form
    $('#insert_form').on("submit", function (event) {
        event.preventDefault();
        if ($('#firstName').val() == "") {
            alert("Firstname is required");
        } else if ($('#surname').val() == '') {
            alert("Surname is required");
        } else {
            $.ajax({
                url: "asset/update_employee.php",
                method: "POST",
                data: $('#insert_form').serialize(),
                beforeSend: function () {
                    $('#insert').val("Inserting");
                },
                success: function (data) {
                    $('#insert_form')[0].reset();
                    $('#add_data_Modal').modal('hide');
                    /*$('#employee_table').html(data);*/
                    window.location.href = "index.php";
                }
            });
        }
    });
});

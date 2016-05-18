var TableManaged = function () {

    return {
        //main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }

            // begin first table
            $('#sample_1').dataTable({
                "aoColumns": [
                    {"bSortable": false},
                    null,
                    {"bSortable": false},
                    null,
                    {"bSortable": false},
                    {"bSortable": false}
                ],
                "aLengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength": 5,
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });
            jQuery('#sample_1 .group-checkable').change(function () {
                var set = jQuery(this).attr("data-set");
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function () {
                    if (checked) {
                        $(this).attr("checked", true);
                    } else {
                        $(this).attr("checked", false);
                    }
                    $(this).parents('tr').toggleClass("active");
                });
                jQuery.uniform.update(set);
            });
            jQuery('#sample_1 tbody tr .checkboxes').change(function () {
                $(this).parents('tr').toggleClass("active");
            });
            jQuery('#sample_1_wrapper .dataTables_filter input').addClass("form-control input-medium"); // modify table search input
            jQuery('#sample_1_wrapper .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
            //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialize select2 dropdown

            // begin second table
            $('#sample_2').dataTable({
                "aLengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength": 10,
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });
            jQuery('#sample_2 .group-checkable').change(function () {
                var set = jQuery(this).attr("data-set");
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function () {
                    if (checked) {
                        $(this).attr("checked", true);
                    } else {
                        $(this).attr("checked", false);
                    }
                });
                jQuery.uniform.update(set);
            });
            jQuery('#sample_2_wrapper .dataTables_filter input').addClass("form-control input-small"); // modify table search input
            jQuery('#sample_2_wrapper .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
            jQuery('#sample_2_wrapper .dataTables_length select').select2(); // initialize select2 dropdown

            // begin: third table
            $('#sample_3').dataTable({
                "aLengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength": 5,
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });
            jQuery('#sample_3 .group-checkable').change(function () {
                var set = jQuery(this).attr("data-set");
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function () {
                    if (checked) {
                        $(this).attr("checked", true);
                    } else {
                        $(this).attr("checked", false);
                    }
                });
                jQuery.uniform.update(set);
            });
            jQuery('#sample_3_wrapper .dataTables_filter input').addClass("form-control input-small"); // modify table search input
            jQuery('#sample_3_wrapper .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
            jQuery('#sample_3_wrapper .dataTables_length select').select2(); // initialize select2 dropdown

            // dashboard deposit table
            $('#deposit').dataTable({
                "aoColumns": [
                    {"bSortable": false},
                    {"bSortable": false},
                    {"bSortable": false},
                    {"bSortable": false},
                    {"bSortable": false},
                    {"bSortable": false},
                    {"bSortable": false},
                    {"bSortable": false}
                ],
                "aaSorting": [ [0,'desc'] ],
                "aLengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength": 5,
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });
            jQuery('#deposit .group-checkable').change(function () {
                var set = jQuery(this).attr("data-set");
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function () {
                    if (checked) {
                        $(this).attr("checked", true);
                    } else {
                        $(this).attr("checked", false);
                    }
                    $(this).parents('tr').toggleClass("active");
                });
                jQuery.uniform.update(set);
            });
            jQuery('#deposit tbody tr .checkboxes').change(function () {
                $(this).parents('tr').toggleClass("active");
            });
            jQuery('#deposit_wrapper .dataTables_filter input').addClass("form-control input-medium"); // modify table search input
            jQuery('#deposit_wrapper .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
            jQuery('#deposit_wrapper .dataTables_length select').select2(); // initialize select2 dropdown

            // dashboard deposit_auto table
            $('#deposit_auto').dataTable({
                "aoColumns": [
                    {"bSortable": false},
                    {"bSortable": false},
                    {"bSortable": false},
                    {"bSortable": false},
                    {"bSortable": false},
                    {"bSortable": false},
                    {"bSortable": false},
                    {"bSortable": false},
                    {"bSortable": false}
                ],
                "aaSorting": [ [0,'desc'] ],
                "aLengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength": 5,
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });
            jQuery('#deposit_auto .group-checkable').change(function () {
                var set = jQuery(this).attr("data-set");
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function () {
                    if (checked) {
                        $(this).attr("checked", true);
                    } else {
                        $(this).attr("checked", false);
                    }
                    $(this).parents('tr').toggleClass("active");
                });
                jQuery.uniform.update(set);
            });
            jQuery('#deposit_auto tbody tr .checkboxes').change(function () {
                $(this).parents('tr').toggleClass("active");
            });
            jQuery('#deposit_auto_wrapper .dataTables_filter input').addClass("form-control input-medium"); // modify table search input
            jQuery('#deposit_auto_wrapper .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
            jQuery('#deposit_auto_wrapper .dataTables_length select').select2();

            // dashboard withdraw table
            $('#withdraw').dataTable({
                "aoColumns": [
                    {"bSortable": false},
                    {"bSortable": false},
                    {"bSortable": false},
                    {"bSortable": false},
                    {"bSortable": false},
                    {"bSortable": false},
                    {"bSortable": false}

                ],
                "aaSorting": [ [0,'desc'] ],
                "aLengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength": 5,
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });
            jQuery('#withdraw .group-checkable').change(function () {
                var set = jQuery(this).attr("data-set");
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function () {
                    if (checked) {
                        $(this).attr("checked", true);
                    } else {
                        $(this).attr("checked", false);
                    }
                    $(this).parents('tr').toggleClass("active");
                });
                jQuery.uniform.update(set);
            });
            jQuery('#withdraw tbody tr .checkboxes').change(function () {
                $(this).parents('tr').toggleClass("active");
            });
            jQuery('#withdraw_wrapper .dataTables_filter input').addClass("form-control input-medium"); // modify table search input
            jQuery('#withdraw_wrapper .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
            jQuery('#withdraw_wrapper .dataTables_length select').select2(); // initialize select2 dropdown

            // dashboard member table
            $('#member').dataTable({
                "aoColumns": [
                    {"bSortable": false},
                    {"bSortable": false},
                    {"bSortable": false},
                    {"bSortable": false},
                    {"bSortable": false},
                    {"bSortable": false},
                    {"bSortable": false}
                ],
                "aLengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength": 5,
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });
            jQuery('#member .group-checkable').change(function () {
                var set = jQuery(this).attr("data-set");
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function () {
                    if (checked) {
                        $(this).attr("checked", true);
                    } else {
                        $(this).attr("checked", false);
                    }
                    $(this).parents('tr').toggleClass("active");
                });
                jQuery.uniform.update(set);
            });
            jQuery('#member tbody tr .checkboxes').change(function () {
                $(this).parents('tr').toggleClass("active");
            });
            jQuery('#member_wrapper .dataTables_filter input').addClass("form-control input-medium"); // modify table search input
            jQuery('#member_wrapper .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
            jQuery('#member_wrapper .dataTables_length select').select2(); // initialize select2 dropdown

            // dashboard sms table
            $('#sms').dataTable({
                "aoColumns": [
                    {"bSortable": false},
                    {"bSortable": false},
                    {"bSortable": false},
                    {"bSortable": false},
                    {"bSortable": false},
                    {"bSortable": false}
                ],
                "aLengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength": 5,
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });
            jQuery('#sms .group-checkable').change(function () {
                var set = jQuery(this).attr("data-set");
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function () {
                    if (checked) {
                        $(this).attr("checked", true);
                    } else {
                        $(this).attr("checked", false);
                    }
                    $(this).parents('tr').toggleClass("active");
                });
                jQuery.uniform.update(set);
            });
            jQuery('#sms tbody tr .checkboxes').change(function () {
                $(this).parents('tr').toggleClass("active");
            });
            jQuery('#sms_wrapper .dataTables_filter input').addClass("form-control input-medium"); // modify table search input
            jQuery('#sms_wrapper .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
            jQuery('#sms_wrapper .dataTables_length select').select2(); // initialize select2 dropdown

            // view deposit table
            $('#deposit_view').dataTable({

                "aoColumns": [
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    {"bSortable": false},
                    {"bSortable": false}
                ],
                "aaSorting": [ [0,'desc'] ],
                "aLengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength": 15,
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{

                        'bSortable': true,
                        'aTargets': [0]
                    }
                ]
            });
            jQuery('#deposit_view .group-checkable').change(function () {
                var set = jQuery(this).attr("data-set");
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function () {
                    if (checked) {
                        $(this).attr("checked", true);
                    } else {
                        $(this).attr("checked", false);
                    }
                    $(this).parents('tr').toggleClass("active");
                });
                jQuery.uniform.update(set);
            });
            jQuery('#deposit_view tbody tr .checkboxes').change(function () {
                $(this).parents('tr').toggleClass("active");
            });
            jQuery('#deposit_view_wrapper .dataTables_filter input').addClass("form-control input-medium"); // modify table search input
            jQuery('#deposit_view_wrapper .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
            jQuery('#deposit_view_wrapper .dataTables_length select').select2(); // initialize select2 dropdown

            // view withdraw table
            $('#withdraw_view').dataTable({
                "aoColumns": [
                    null,
                    null,
                    null,
                    null,
                    null,
                    {"bSortable": false},
                    {"bSortable": false}
                ],
                "aaSorting": [ [0,'desc'] ],
                "aLengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength": 15,
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': true,
                        'aTargets': [0]
                    }
                ]
            });

            jQuery('#withdraw_view .group-checkable').change(function () {
                var set = jQuery(this).attr("data-set");
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function () {
                    if (checked) {
                        $(this).attr("checked", true);
                    } else {
                        $(this).attr("checked", false);
                    }
                    $(this).parents('tr').toggleClass("active");
                });
                jQuery.uniform.update(set);

            });

            jQuery('#withdraw_view tbody tr .checkboxes').change(function () {
                $(this).parents('tr').toggleClass("active");
            });

            jQuery('#withdraw_view_wrapper .dataTables_filter input').addClass("form-control input-medium"); // modify table search input
            jQuery('#withdraw_view_wrapper .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
            jQuery('#withdraw_view_wrapper .dataTables_length select').select2(); // initialize select2 dropdown

            // view member table
            $('#member_view').dataTable({
                "aoColumns": [
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    {"bSortable": false}
                ],
                "aLengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength": 5,
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });

            jQuery('#member_view .group-checkable').change(function () {
                var set = jQuery(this).attr("data-set");
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function () {
                    if (checked) {
                        $(this).attr("checked", true);
                    } else {
                        $(this).attr("checked", false);
                    }
                    $(this).parents('tr').toggleClass("active");
                });
                jQuery.uniform.update(set);

            });

            jQuery('#member_view tbody tr .checkboxes').change(function () {
                $(this).parents('tr').toggleClass("active");
            });

            jQuery('#member_view_wrapper .dataTables_filter input').addClass("form-control input-medium"); // modify table search input
            jQuery('#member_view_wrapper .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
            jQuery('#member_view_wrapper .dataTables_length select').select2(); // initialize select2 dropdown

            // view sms table
            $('#sms_view').dataTable({
                "aoColumns": [
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null
                ],
                "aLengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength": 5,
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });
            jQuery('#sms_view .group-checkable').change(function () {
                var set = jQuery(this).attr("data-set");
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function () {
                    if (checked) {
                        $(this).attr("checked", true);
                    } else {
                        $(this).attr("checked", false);
                    }
                    $(this).parents('tr').toggleClass("active");
                });
                jQuery.uniform.update(set);
            });
            jQuery('#sms_view tbody tr .checkboxes').change(function () {
                $(this).parents('tr').toggleClass("active");
            });
            jQuery('#sms_view_wrapper .dataTables_filter input').addClass("form-control input-medium"); // modify table search input
            jQuery('#sms_view_wrapper .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
            jQuery('#sms_view_wrapper .dataTables_length select').select2(); // initialize select2 dropdown

            // view sbobet table
            $('#sbobet_view').dataTable({
                "aoColumns": [
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    {"bSortable": false}
                ],
                "aLengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength": 5,
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });
            jQuery('#sbobet_view .group-checkable').change(function () {
                var set = jQuery(this).attr("data-set");
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function () {
                    if (checked) {
                        $(this).attr("checked", true);
                    } else {
                        $(this).attr("checked", false);
                    }
                    $(this).parents('tr').toggleClass("active");
                });
                jQuery.uniform.update(set);
            });
            jQuery('#sbobet_view tbody tr .checkboxes').change(function () {
                $(this).parents('tr').toggleClass("active");
            });
            jQuery('#sbobet_view_wrapper .dataTables_filter input').addClass("form-control input-medium"); // modify table search input
            jQuery('#sbobet_view_wrapper .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
            jQuery('#sbobet_view_wrapper .dataTables_length select').select2(); // initialize select2 dropdown

            // log table
            $('#log_view').dataTable({
                "aoColumns": [
                    {"bSortable": false},
                    null,
                    null,
                    null,
                ],
                "aLengthMenu": [
                    [30, 60, 90, -1],
                    [30, 60, 90, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength": 30,
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });
            jQuery('#log_view .group-checkable').change(function () {
                var set = jQuery(this).attr("data-set");
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function () {
                    if (checked) {
                        $(this).attr("checked", true);
                    } else {
                        $(this).attr("checked", false);
                    }
                    $(this).parents('tr').toggleClass("active");
                });
                jQuery.uniform.update(set);
            });
            jQuery('#log_view tbody tr .checkboxes').change(function () {
                $(this).parents('tr').toggleClass("active");
            });
            jQuery('#log_view_wrapper .dataTables_filter input').addClass("form-control input-medium"); // modify table search input
            jQuery('#log_view_wrapper .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
            jQuery('#log_view_wrapper .dataTables_length select').select2(); // initialize select2 dropdown
        }
    };

}();

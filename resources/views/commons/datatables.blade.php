        $('#{{$id}}').DataTable({
            "bSort": true,
            "scrollX": true,
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": true,
            "order": [[0, 'desc']],
            "bAutoWidth": true,
            "lengthChange": true,
            "aLengthMenu": [[10, 25,50], [10, 25,50]],
            "iDisplayLength": 10,
            "paging": true,
            "bStateSave": false,
            "oLanguage": {
                "oPaginate": {
                    "sFirst": "<< ", "sLast": " >>", "sNext": "次へ", "sPrevious": "前へ"
                },
                "sInfo": "全_TOTAL_件中 _START_件から_END_件を表示",
                "sLengthMenu": "表示件数： _MENU_ 件",
                "sInfoEmpty": "[0]件",
                "sZeroRecords": "データがありませんでした",
                "sSearch": "フィルタ：",
                "sInfoFiltered": ""
            }
        });
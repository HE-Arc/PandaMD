<script>
    function OnreadyChangeRight() {
        let url = "{{route('changeRight',':id')}}";
        let selectData={};
        $("select[id^='selectRight']").each(function () {
            selectData[$(this).attr('name')]=$(this).val();
        });

        $("select[id^='selectRight']").on('change', function () {
            let id = $(this).attr('title');
            url = url.replace(":id", id);
            let right = $(this).val();
            fetch(url, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({newRight: right})
            }).then(response => {
                if (!response.ok) {
                    $(this).val(selectData[id]).select();
                    throw new Error(response.statusText)

                }

            })
                .catch(error => {
                    console.log(error);
                    swal({
                        type: 'error',
                        title: 'Something went wrong!',
                        text: 'Please try again',
                    })
                })

        });

    }
</script>

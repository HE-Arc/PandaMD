<script>
    function OnreadyChangeRight() {
        let url = "{{route('changeRight',':id')}}";
        $("select[id^='selectRight']").on('focusin',function () {
            beforeValue=$(this).val();
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
                    $(`#selectedFile${id} option[value=${beforeValue}]`).prop('selected',true);
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

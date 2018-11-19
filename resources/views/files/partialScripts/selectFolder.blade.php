<script>

    function OnreadyChangeFolder() {

        let url = "{{route('changeFolderId',':id')}}";

        $("a[id^='folder']").on('click',function () {
            let fileId=$(this).attr('name');
            url = url.replace(":id", fileId);
            let newFolderId = $(this).attr('value');
            fetch(url, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({newFolderId: 3})
            }).then(response => {
                console.log(JSON.stringify({newFolderId: newFolderId}));
                if (!response.ok) {
                    throw new Error(response.statusText)
                }

                location.reload();

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

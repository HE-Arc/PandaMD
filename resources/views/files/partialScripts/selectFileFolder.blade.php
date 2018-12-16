<script>

    function OnreadyChangeFileFolder() {

        let url = "{{route('changeFileFolderId',':id')}}";

        $("select[id^='selectedFile']").on('focus',function () {
            beforeValue=$(this).val();
        });

        $("select[id^='selectedFile']").on('change', function () {
            let fileId = $(this).attr('title');
            url = url.replace(":id", fileId);
            //change clicked folder to bold and selected icon
            let newFolderId = $(this).val();
            fetch(url, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({newFolderId: newFolderId})
            }).then(response => {
                if (!response.ok) {
                    $(`#selectedFile${fileId} option[value=${beforeValue}]`).prop('selected',true);
                    throw new Error(response.statusText)
                }
                return response.json();

            }).then(function (data) {
                if(!data.state){
                    $(`#selectedFile${fileId} option[value=${beforeValue}]`).prop('selected',true);
                    throw new Error(response.statusText)
                }
                else{
                    location.reload();
                }
            })
                .catch(error => {
                    swal({
                        type: 'error',
                        title: 'Something went wrong!',
                        text: 'Please try again',
                    })
                })
        });


    }
</script>

<script>

    function OnreadyChangeFolderFolder() {

        let url = "{{route('changeFolderFolderId',':id')}}";
        let selectData={};

        $("select[id^='selectedFolder']").on('focus',function () {
            beforeValue=$(this).val();
        });
        $("select[id^='selectedFolder']").on('change',function () {
            let folderId=$(this).attr('name');
            url = url.replace(":id", folderId);
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
                    $(`#selectedFolder${folderId} option[value=${beforeValue}]`).prop('selected',true);
                    throw new Error(response.statusText)
                }
                return response.json();

            }).then(function (data) {
                if(!data.state){
                    $(`#selectedFolder${folderId} option[value=${beforeValue}]`).prop('selected',true);
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

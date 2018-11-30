<script>

    function OnreadyChangeFolderFolder() {

        let url = "{{route('changeFolderFolderId',':id')}}";
        let selectData={};
        $("select[id^='selectedFolder']").each(function () {
            selectData[$(this).attr('name')]=$(this).val();
        });
        $("select[id^='selectedFolder']").on('change',function () {
            let folderId=$(this).attr('name');
            url = url.replace(":id", folderId);
            //change clicked folder to bold and selected icon
            let newFolderId = $(this).val();
            console.log(url);
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
                    $(this).val(selectData[folderId]).select();
                    throw new Error(response.statusText)
                }
                return response.json();

            }).then(function (data) {
                if(!data.state){
                    $(this).val(selectData[folderId]).select();
                    throw new Error(response.statusText)
                }
                else{
                    location.reload();
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

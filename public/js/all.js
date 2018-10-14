function initSimpleMde(fileContent) {
    var simplemde = new global_simplemde({
        element: document.getElementById('editor-md'),
        initialValue: fileContent,
        previewRender: function (plainText) {
            return global_markdown_it.render(plainText); // Returns HTML from a custom parser
        },
    });
}

function renderMarkdown(plaintext) {
    return global_markdown_it.render(plaintext);
}
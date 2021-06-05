
let Blog = {
    loadTags : function (){
        let selectElement = document.querySelector("#tags");
        selectElement.length = 0;
        axios.get(window.location.origin + "/blog/get_tags").then((res)=>{
            ;
            for (let i = 0; i < res.data.length; i++) {
                const element = res.data[i];
                console.log(element);
                selectElement.add(new Option(element.name, element.id));
            }
        })
    },
    loadCategories: function (){
        let selectElement = document.querySelector("#categories");
        selectElement.length = 0;
        axios.get(window.location.origin + "/blog/get_categories").then((res)=>{
            for (let i = 0; i < res.data.length; i++) {
                const element = res.data[i];
                selectElement.add(new Option(element.name, element.id));
            }
        })
    },
    init_ckeditor: function(){
        CKEDITOR.editorConfig = function( config ) {

            // Set the default order of the editor buttons
            config.toolbarGroups = [
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                { name: 'styles', groups: [ 'styles' ] },
                { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
                { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
                { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
                { name: 'links', groups: [ 'links' ] },
                { name: 'insert', groups: [ 'insert' ] },
                { name: 'forms', groups: [ 'forms' ] },
                { name: 'tools', groups: [ 'tools' ] },
                { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
                { name: 'others', groups: [ 'others' ] },
                { name: 'about', groups: [ 'about' ] },
                '/',
                { name: 'colors', groups: [ 'colors' ] }
            ];

            // Remove un-needed buttons
            config.removeButtons = 'Subscript,Superscript,Undo,Redo,Cut,Copy,Paste,Scayt,Indent,Outdent,About,Styles';

            // Set the most common block elements.
            config.format_tags = 'p;h1;h2;h3;h4;pre';

            // CSS overrides
            config.resize_enabled = false;
            config.height = "45rem";

            // Simplify the dialog windows.
            config.removeDialogTabs = 'image:advanced;link:advanced';
        };
    },
    loadModal: function(){
        let el = document.getElementById('modal_confirm');
        let modal = new bootstrap.Modal(el, {
            keyboard: false
        });
        modal.show();


    }
}

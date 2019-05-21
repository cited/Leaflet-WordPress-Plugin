    jQuery(document).ready(function(){

		//jQuery(".mf_link_open_modal").SelectTag();

	});







tinymce.init({

    selector: "textarea.elm1",

    theme: "modern",

    plugins: [

        "jbimages advlist autolink lists link image charmap print preview hr anchor pagebreak",

        "searchreplace wordcount visualblocks visualchars code fullscreen",

        "insertdatetime media nonbreaking save table contextmenu directionality",

        "emoticons template paste textcolor colorpicker textpattern"

    ],

    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",

    toolbar2: "print preview media | forecolor backcolor emoticons |  jbimages",

	

    image_advtab: true,

    templates: [

        {title: 'Test template 1', content: 'Test 1'},

        {title: 'Test template 2', content: 'Test 2'}

    ],
	
	relative_urls: false,
	remove_script_host : false,
	convert_urls : true,
	
	
     relative_urls : false

});
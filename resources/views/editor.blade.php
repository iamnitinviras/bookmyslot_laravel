<script src="{{ asset('js/tinymce/tinymce.min.js', config('app.redirect_https')) }}" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '.editor',
        toolbar_sticky:true,
        plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen link template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars',
        editimage_cors_hosts: ['picsum.photos'],
        menubar: 'insert table',
        toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap | fullscreen  preview print | link | ltr rtl ',
        automatic_uploads: true
    });
</script>

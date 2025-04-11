<div>
    <div wire:ignore>
        <input id="trix-editor-content" type="hidden" name="content" value="{{ $content }}">
        <trix-editor input="trix-editor-content" placeholder="Enter description"></trix-editor>
    </div>

    <script>
        const trixEditor = document.getElementById('trix-editor-content');
        addEventListener('trix-blur', (event) => {
            @this.set('content', trixEditor.getAttribute('value'))
        })
    </script>
</div>

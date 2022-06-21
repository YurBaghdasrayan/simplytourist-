<template>
    <div>
        <quill class="editor" ref="myTextEditor" v-model="content" :config="editorOption"></quill>
        <input type="hidden" name="text" :value="JSON.stringify(content)">

    </div>
</template>

<script>
export default {
    name: "Wysiwig",
    data(){
        return{
            content: null,
            editorOption: {
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        ['code-block'],
                        [{'header': 1}, {'header': 2}],
                        [{'list': 'ordered'}, {'list': 'bullet'}],
                        [{'script': 'sub'}, {'script': 'super'}],
                        [{'indent': '-1'}, {'indent': '+1'}],
                        ['clean'],
                    ],
                    syntax: {
                        highlight: text => hljs.highlightAuto(text).value
                    }
                }
            }
        }
    }
}
</script>

<style scoped>

</style>

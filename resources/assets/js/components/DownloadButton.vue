<template>
  <a
    :href="downloadUrl"
    target="_blank"
    xclass="bg-grey-light hover:bg-grey text-grey-darkest font-bold py-2 px-4 rounded inline-flex items-center"
  >
    {{ rowData.revision }}.jar
  </a>
</template>

<script>
export default {
  props: {
    rowData: {
      type: Object,
      required: true
    }
  },
  computed: {
    downloadUrl () {
      return this.rowData.links.gamepack
    }
  }
}
</script>

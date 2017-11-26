<template>
  <vuetable ref="vuetable"
    :api-url="apiUrl"
    :fields="fields"
    pagination-path="meta"
  />
</template>

<script>
export default {
  props: {
    apiUrl: String
  },
  data () {
    return {
      fields: [
        {
          name: 'revision',
          title: 'Revision',
          titleClass: 'px-4'
        },
        {
          name: 'size',
          title: 'Size (kb)',
          titleClass: 'px-4',
          callback: 'formatSizeKb'
        },
        {
          name: '__component:download-button',
          titleClass: 'px-4',
          title: 'Download',
        }
      ]
    }
  },
  methods: {
    formatSizeKb (size) {
      return (size / 1024).toFixed(2)
    }
  }
}
</script>

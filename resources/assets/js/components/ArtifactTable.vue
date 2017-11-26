<template>
  <div>
    <vuetable ref="vuetable"
      :api-url="apiUrl"
      :fields="fields"
      pagination-path="meta"
      @vuetable:pagination-data="onPaginationData"
    />
    <vuetable-pagination ref="pagination"
      @vuetable-pagination:change-page="onChangePage"
    />
  </div>
</template>

<script>
import Vuetable from 'vuetable-2/src/components/Vuetable'
import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'

export default {
  props: {
    apiUrl: String
  },
  components: {
    Vuetable,
    VuetablePagination
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
    },
    onPaginationData (paginationData) {
      this.$refs.pagination.setPaginationData(paginationData)
    },
    onChangePage (page) {
      this.$refs.vuetable.changePage(page)
    }
  }
}
</script>

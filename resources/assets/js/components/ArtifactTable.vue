<template>
  <vuetable ref="vuetable"
    :api-url="apiUrl"
    :fields="['revision', 'url']"
    pagination-path="meta"
  />
</template>

<script>
export default {
  props: {
    apiUrl: String
  }
}
</script>

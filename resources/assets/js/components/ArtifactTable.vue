<template>
  <vuetable ref="vuetable"
    api-url="/api/v2/packs"
    :fields="['revision', 'url']"
    pagination-path="meta"
  />
</template>

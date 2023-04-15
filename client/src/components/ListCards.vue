<script>
export default {
  name: "ListComponent",
  data() {
    return {
    };
  },
  props: {
    items: {
      type: Array,
      required: true
    }
  }
};
</script>

<template>
    <div class="row">
      <div class="col-4" v-for="item in items"
        :key="item.id">
        <div class="card mb-3">
            <img class="card-img-bottom" :src="item.img" :alt="item.title">
            <div class="card-body">
                <h5 class="card-title">{{ item.title }}</h5>
                <p class="card-text">{{ item.text }}</p>
                <button class="btn btn-primary" @click="$emit('click', item)">Acheter</button>
            </div>
        </div>
      </div>
    </div>
  </template>

<style scoped>
.row{
    margin: 0;
    padding: 0;
}
.card{
    border: none;
    border-radius: 0;
    margin: 0;
    padding: 0;
}
.card-img-top{
    width: 100%;
    height: 200px;
    object-fit: cover;
}
.card-body{
    padding: 0.5rem;
}
.card-title{
    font-size: 1.5rem;
}
.card-text{
    font-size: 1.2rem;
}

</style>
<template>
  <div class="modal">
    <div class="modal-content">
      <h2>Configuration serveur</h2>
      <form @submit.prevent="saveConfig">
        <label for="url" title="url">🖥️</label>
        <input type="text" id="url" v-model="url" required><br>
        <label for="user" title="user">👤</label>
        <input type="text" id="user" v-model="user"><br>
        <label for="password" title="password">🔑</label>
        <input type="text" id="password" v-model="password"><br>
        <button type="submit" title="Save">💾</button>
      </form>
    </div>
  </div>
</template>
  
<script>
export default {
  data() {
    return {
      url: '',
      user: '',
      password: '',
    };
  },
  created() {
    const savedConfig = JSON.parse(localStorage.getItem('serverConfig'));
    if (savedConfig) {
      this.url = savedConfig.url;
      this.user = savedConfig.user;
      this.password = savedConfig.password;
    }
  },
  methods: {
    saveConfig() {
      const serverConfig = {
        url: this.url,
        user: this.user,
        password: this.password,
      };
      localStorage.setItem('serverConfig', JSON.stringify(serverConfig));
      this.$emit('close');
    },

  },
};
</script>

<style scoped>
label {
  display: inline-block;
  padding-right: .5em;
  margin: .5em 0;
}
</style>
<template>
    <div>
      <span v-if="isConnected" title="SSH server available" @click="testSshConnection">✅</span>
      <span v-else title="SSH server unavailable" @click="testSshConnection">❌</span>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        isConnected: false,
      };
    },
    methods: {
      testSshConnection() {
        // Mettez à jour isConnected en fonction du résultat du test de connexion
        // Remplacez cette logique par votre propre test de connexion SSH
        console.log('Testing SSH connection');
        this.isConnected = !this.isConnected; // C'est pour la démonstration, changez cette logique selon votre besoin
        this.$emit('ssh-connection-tested', this.isConnected); // Émettre un événement avec le résultat du test
      },
    },
  };
  </script>
  
  <style scoped>
  div {
    float: left;
    margin: 2px .5em 0 0;
  }
  </style>
  
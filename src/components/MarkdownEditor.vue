<template>
    <div>
      <textarea ref="textarea"></textarea>
    </div>
  </template>
  
  <script>
  import EasyMDE from 'easymde/dist/easymde.min';
  import 'easymde/dist/easymde.min.css';
  
  export default {
    mounted() {
      const todayDate = new Date().toLocaleDateString();
      this.markdownContent = localStorage.getItem(`markdownContent_${todayDate}`) || '';
  
      const easyMDE = new EasyMDE({
        element: this.$refs.textarea,
        initialValue: this.markdownContent,
      });
  
      easyMDE.codemirror.on('change', () => {
        this.markdownContent = easyMDE.value();
      });
  
      this.lastInteractionTime = Date.now();
      
      this.inactivityTimer = setInterval(this.checkInactivity, 10000);
      window.addEventListener('blur', this.handleWindowBlur);
      window.addEventListener('beforeunload', this.handleBeforeUnload);
    },
  
    data() {
      return {
        markdownContent: '',
        lastInteractionTime: 0,
        inactivityTimer: null,
        inactivityThreshold: 10000,
      };
    },
  
    beforeUnmount() {
      clearInterval(this.inactivityTimer);
    },
  
    methods: {
      checkInactivity() {
        const currentTime = Date.now();
        if (currentTime - this.lastInteractionTime >= this.inactivityThreshold) {
          this.save();
        }
      },
  
      handleWindowBlur() {
        this.lastInteractionTime = Date.now();
      },
  
      handleBeforeUnload() {
        this.save();
      },
  
      save() {
        const todayDate = new Date().toLocaleDateString();
        localStorage.setItem(`markdownContent_${todayDate}`, this.markdownContent);
      },
    },
  };
  </script>
  
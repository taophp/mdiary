(function(){"use strict";var e={1041:function(e,n,t){var o=t(9242),r=t(3396);function i(e,n,t,o,i,a){const c=(0,r.up)("markdown-editor");return(0,r.wg)(),(0,r.iD)("div",null,[(0,r.Wm)(c)])}const a={ref:"textarea"};function c(e,n,t,o,i,c){return(0,r.wg)(),(0,r.iD)("div",null,[(0,r._)("textarea",a,null,512)])}var s=t(4481),l=t.n(s),u={mounted(){const e=(new Date).toLocaleDateString();this.markdownContent=localStorage.getItem(`markdownContent_${e}`)||"";const n=new(l())({element:this.$refs.textarea,initialValue:this.markdownContent});n.codemirror.on("change",(()=>{this.markdownContent=n.value()})),this.lastInteractionTime=Date.now(),this.inactivityTimer=setInterval(this.checkInactivity,1e4),window.addEventListener("blur",this.handleWindowBlur),window.addEventListener("beforeunload",this.handleBeforeUnload)},data(){return{markdownContent:"",lastInteractionTime:0,inactivityTimer:null,inactivityThreshold:1e4}},beforeUnmount(){clearInterval(this.inactivityTimer)},methods:{checkInactivity(){const e=Date.now();e-this.lastInteractionTime>=this.inactivityThreshold&&this.save()},handleWindowBlur(){this.lastInteractionTime=Date.now()},handleBeforeUnload(){this.save()},save(){const e=(new Date).toLocaleDateString();localStorage.setItem(`markdownContent_${e}`,this.markdownContent)}}},d=t(89);const f=(0,d.Z)(u,[["render",c]]);var h=f,v={components:{MarkdownEditor:h}};const w=(0,d.Z)(v,[["render",i]]);var m=w,g=t(5431);(0,g.z)("/service-worker.js",{ready(){console.log("App is being served from cache by a service worker.\nFor more details, visit https://goo.gl/AFskqB")},registered(){console.log("Service worker has been registered.")},cached(){console.log("Content has been cached for offline use.")},updatefound(){console.log("New content is downloading.")},updated(){console.log("New content is available; please refresh.")},offline(){console.log("No internet connection found. App is running in offline mode.")},error(e){console.error("Error during service worker registration:",e)}}),(0,o.ri)(m).mount("#app")}},n={};function t(o){var r=n[o];if(void 0!==r)return r.exports;var i=n[o]={exports:{}};return e[o].call(i.exports,i,i.exports,t),i.exports}t.m=e,function(){var e=[];t.O=function(n,o,r,i){if(!o){var a=1/0;for(u=0;u<e.length;u++){o=e[u][0],r=e[u][1],i=e[u][2];for(var c=!0,s=0;s<o.length;s++)(!1&i||a>=i)&&Object.keys(t.O).every((function(e){return t.O[e](o[s])}))?o.splice(s--,1):(c=!1,i<a&&(a=i));if(c){e.splice(u--,1);var l=r();void 0!==l&&(n=l)}}return n}i=i||0;for(var u=e.length;u>0&&e[u-1][2]>i;u--)e[u]=e[u-1];e[u]=[o,r,i]}}(),function(){t.n=function(e){var n=e&&e.__esModule?function(){return e["default"]}:function(){return e};return t.d(n,{a:n}),n}}(),function(){t.d=function(e,n){for(var o in n)t.o(n,o)&&!t.o(e,o)&&Object.defineProperty(e,o,{enumerable:!0,get:n[o]})}}(),function(){t.g=function(){if("object"===typeof globalThis)return globalThis;try{return this||new Function("return this")()}catch(e){if("object"===typeof window)return window}}()}(),function(){t.o=function(e,n){return Object.prototype.hasOwnProperty.call(e,n)}}(),function(){var e={143:0};t.O.j=function(n){return 0===e[n]};var n=function(n,o){var r,i,a=o[0],c=o[1],s=o[2],l=0;if(a.some((function(n){return 0!==e[n]}))){for(r in c)t.o(c,r)&&(t.m[r]=c[r]);if(s)var u=s(t)}for(n&&n(o);l<a.length;l++)i=a[l],t.o(e,i)&&e[i]&&e[i][0](),e[i]=0;return t.O(u)},o=self["webpackChunkmdiary"]=self["webpackChunkmdiary"]||[];o.forEach(n.bind(null,0)),o.push=n.bind(null,o.push.bind(o))}();var o=t.O(void 0,[998],(function(){return t(1041)}));o=t.O(o)})();
//# sourceMappingURL=app.9f572024.js.map
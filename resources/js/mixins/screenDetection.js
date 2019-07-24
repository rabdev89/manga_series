export default {
  methods: {
    isXS() {
      return window.matchMedia("(max-width: 600px)").matches;
    },
    isSM() {
      return window.matchMedia("(min-width: 600px)").matches;
    },
    isMD() {
      return window.matchMedia("(min-width: 1439px)").matches;
    },
    isLG() {
      return window.matchMedia("(min-width: 1919px)").matches;
    }
  }
};
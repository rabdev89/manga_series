export default {
  methods: {
    convertStatus(status) {
      return 'On Going';
    },
    formatNum(num) {
      num = num.toString();
      if(num.length == 4) {
        return num[0]+','+num.substr(1, 3);
      } else if(num.length == 5) {
        return num.substr(0, 2) +','+num.substr(2, 4);
      } else if(num.length == 6) {
        return num.substr(0, 3) +','+num.substr(3, 5);
      } else if(num.length == 7) {
        return num[0] +','+num.substr(1, 3) +','+num.substr(4, 6);
      } else if(num.length == 8) {
        return num[0] + '' + num[1] +'M+';
      } else if(num.length == 9) {
        return num[0] + '' +num[1] + num[2] + 'M+';
      } else if(num.length == 10) {
        return num[0] + 'B+';
      }
      return num;
    },
    toSlug(str) {
      return str.replace(/ /g, '-').toLowerCase();
    },
    normalize(str) {
      return str.replace(/-/g,' ').toUpperCase();
    },
    formatDate(unix) {
      var a = new Date(unix * 1000);
      var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
      var year = a.getFullYear();
      var month = months[a.getMonth()];
      var date = a.getDate();
      var time = date + ' ' + month + ' ' + year;
      return time;
    }
  }
}
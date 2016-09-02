var App = {};
App.WebAPI = App.Template = App.Util = {};

function myAjax(url,data) {
   var defer = $.Deferred();
   $.ajax({
          url:url,
          data:data,
      }).done(function(res){
          defer.resolve(res);
      });
   return defer.promise();
}


$(function(){
  var data = {};
  data.tags = [];
  data.freeWord = [];

  $('#search .priority .search-post').click(function(){
    data.priority = $(this).data('priority');
    $('#search .priority .search-post').removeClass('selected');
    $(this).addClass('selected');
    $(this).prevAll().addClass('selected');
    // console.log(data);
    App.WebAPI.searchPage(data);
  });

  $('#search .tags .search-post').click(function(){
    var tagNum = $(this).data('tag');
    if ( $.inArray(tagNum, data.tags) >= 0) {
      data.tags.splice($.inArray(tagNum, data.tags),1);
    } else {
      data.tags.push(tagNum);
    }
    $('#search .tags .search-post').removeClass('selected');
    for (i=0;i<data.tags.length;i++){
      $("[data-tag="+data.tags[i]+"]").addClass('selected');
    }
    // console.log(tagNum,data.tags);
    App.WebAPI.searchPage(data);
  });

  $('#search .free-word .search-post').keyup(function(e){
      var freeWord = $(this).val();
      // スペース区切り
      data.freeWord = [];
      data.freeWord.push(freeWord);
      console.log(data);
      App.WebAPI.searchPage(data);
  });

  $('#go').click(function(){
      // DOM入れ替え
      $('#result-table').html('クローリング中だよ');
      // start crawle
      App.WebAPI.goCrawle(data);
      // dom 入れ替え
    // console.log(data);
  });

  $('#fillter-status li').click(function(e){
      var status = $(this).data('status');
      if ( status === "all" ) {
          $('.result-records tr').show();
      } else {
          $('.result-records tr').hide();
          $('.result-records tr.status-'+status).show();
      }
  });
});

App.WebAPI.searchPage = function(data){
  $.ajax({
    type: "POST",
    url: "/api/search_page",
    dataType: "json",
    data: data
  }).done(function( msg ) {
    var $table = $('#result-table table tbody');
    $table.html("");
    var count = msg.page.length;
    $('.page-count').html(count);
    $('.end-time').html(msg.endTime);
    for (i=0;i<count;i++) {
      $tr = App.Util.tempReplace(App.Template.pageLine,msg.page[i]);
      $table.append($tr);
    }
  }).fail(function( msg){
    console.log(mas);
  });
};

App.WebAPI.goCrawle = function(data){
  $.ajax({
    type: "POST",
    url: "/api/crawle",
    dataType: "json",
    data: data
  }).done(function( msg ) {
      $('#result-table').html('<a href="/history/'+msg.history_id+'" target="_blank">結果だよ</a>');
    console.log(msg);
  }).fail(function( msg){
    console.log(msg);
  });
};

App.Template.pageLine = (function(){/*
<tr><td>{{title}}</td><td>{{url}}</td><td class="priority-stars-{{priority}}"></td></tr>
*/}).toString();

App.Util.tempReplace = function(template,replacements){
  var tmpl,repObj = {};

  Object.keys(replacements).forEach(function(key){
    repObj['{{'+key+'}}'] = this[key];
  },replacements);

  return template.replace(/\{\{[^{]+\}\}/g, function(match) {
      return repObj[match];
    }).split('*')[1];
};

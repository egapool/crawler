var App = {};
App.WebAPI = App.Template = App.Util = {};

$(function(){
  var data = {};
  data.tags = [];

  $('#search .priority .search-post').click(function(){
    data.priority = $(this).data('priority');
    $('#search .priority .search-post').removeClass('selected');
    $(this).addClass('selected');
    $(this).prevAll().addClass('selected');
    console.log(data);
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
    console.log(tagNum,data.tags);
    App.WebAPI.searchPage(data);
  });
});

App.WebAPI.searchPage = function(data){
  $.ajax({
    type: "POST",
    url: "/api/search_page",
    dataType: "json",
    data: data
  }).done(function( msg ) {
    var $table = $('#pages table tbody');
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

App.Template.pageLine = (function(){/*
<tr><td>{{title}}</td><td>{{url}}</td><td>{{priority}}</td></tr>
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
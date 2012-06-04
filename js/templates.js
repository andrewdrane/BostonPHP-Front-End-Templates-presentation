var all_templates = {"code_layout":"<script type=\"text\/javascript\">\n    var code_layout_template = \"{{{template_code}}}\"; \/\/make sure you have escaped the quotes\n    var code_layout_json = {{{data}}};\n<\/script>\n\n{{#headline}}\n<h2>{{headline}}<\/h2>\n{{\/headline}}\n\n{{#subhead}}\n<h4>{{subhead}}<\/h4>\n{{\/subhead}}\n\n<div class=\"row\">\n\n    \n    <ul class=\"nav nav-tabs\">\n        <li class=\"active\"><a href=\"#template\" data-toggle=\"tab\">Template<\/a><\/li>\n        <li><a href=\"#data\" data-toggle=\"tab\">Data<\/a><\/li>\n    <\/ul>\n    <div class=\"tab-content\">\n        <div class=\"span10 offset1 tab-pane active\" id=\"template\">\n            <pre class=\"html\">{{template_display_code}}<\/pre>\n        <\/div>\n\n        <div class=\"span10 offset1 tab-pane\" id=\"data\">\n            <pre class=\"js\">{{data}}<\/pre>\n        <\/div>\n\n\n        <\/div>\n    <\/div>\n\n<div class=\"row\">\n    <div class=\"span8 offset2\">\n        <h3>Result<\/h3>\n        <a href=\"#\" id =\"render-template\">Render the template<\/a>\n\n\n        <div id=\"result\">\n            &nbsp;\n        <\/div>\n    <\/div>\n\n<\/div>\n","partials":"<div id=\"user\">\n    <p id=\"me\">{{first_name}} {{last_name}}<\/p>\n<\/div>\n\n{{#colleagues}}\n    {{>_colleague}}\n{{\/colleagues}}","lists":"<div id=\"user\">\n    <p id=\"me\">{{first_name}} {{last_name}}<\/p>\n<\/div>\n\n{{#colleagues}}\n    <div class=\"colleague\">\n        <p>{{first_name}} {{last_name}}<\/p>\n        <p>Presenting: \n            {{#presenting}} \n                yes \n            {{\/presenting}}\n            {{^presenting}} \n                No \n            {{\/presenting}}\n        <\/p>\n    <\/div>\n{{\/colleagues}}","_next_prev":"{{#nav}}\n    {{#prev}}\n        <li id=\"prev\"><a href=\"?url={{prev}}\" data-template=\"{{prev_data_template}}\">Prev<\/a><\/li>\n    {{\/prev}}\n\n    {{#next}}\n        <li id=\"next\"><a href=\"?url={{next}}\" data-template=\"{{next_data_template}}\">Next<\/a><\/li>\n    {{\/next}}\n{{\/nav}}\n","title_slide":"{{#headline}}\n    <h2>{{headline}}<\/h2>\n{{\/headline}}\n\n{{#subhead}}\n    <h3>{{subhead}}<\/h3>\n{{\/subhead}}\n\n{{#extra}}\n    <h4>{{{.}}}<\/h4>\n{{\/extra}}","escaping":"<h3>Escaped data<\/h3>\n<p>{{data}}<\/p>\n\n<h3>not-escaped data<\/h3>\n<p>{{{data}}}<\/p>\n","main":"<!DOCTYPE html>\n<html>\n<head>\n    <meta http-equiv=\"content-type\" content=\"text\/html; charset=utf-8\" \/>\n    <title>{{title}}<\/title>\n    \n    <link rel=\"stylesheet\" type=\"text\/css\" href=\"style\/stylesheets\/screen.css\" \/>\n    \n    <script src=\"js\/templates.js\"><\/script>\n\n    \n    <script src=\"js\/jquery.js\"><\/script>\n    <script src=\"js\/mustache\/mustache.js\"><\/script>\n    <script src=\"js\/chili\/src\/chili-2.2.js\"><\/script>\n    <script src=\"js\/chili\/src\/recipes.js\"><\/script>\n    <script src=\"js\/bootstrap-tab.js\"><\/script>\n    \n    <script src=\"js\/app.js\"><\/script>\n\n    \n    \n    {{{scripts}}} <!-- If there are additional scripts! -->\n<\/head>\n\n<body>\n    \n    \n    <div id=\"container\">\n    \n            <!-- BEGIN HEADER -->\n            <div id=\"header_container\">\n                <div id=\"header\">\n                    <ul id=\"nav\">\n                    {{#links}}\n                        <li><a href=\"?url={{url}}\">{{title}}<\/a><\/li>\n                    {{\/links}}\n                    \n                    {{>_next_prev}}\n                    <\/ul>\n                <\/div>\n            <\/div>\n            <!-- END HEADER -->\n  \n            <!-- make sure content isn't excaped! -->\n        <div id=\"content\">\n            {{{content}}}\n            \n        <\/div>\n    <\/div>\n\n\n<\/body>\n\n<\/html>","basic":"<div id=\"user\">\n    <p id=\"first_name\">{{first_name}}<\/p>\n    <p id=\"last_name\">{{last_name}}<\/p>\n<\/div>","_code_examples":"<div class=\"row\">\n    <div class=\"span4\"><\/div>\n    <div class=\"span4\"><\/div>\n    <div class=\"span4\"><\/div>\n<\/div>\n\n<div class=\"row\">\n    \n<\/div>\n\n","_colleague":"<div class=\"colleague\">\n    <p>{{first_name}} {{last_name}}<\/p>\n    <p>Presenting: \n        {{#presenting}} \n            yes \n        {{\/presenting}}\n        {{^presenting}} \n            No \n        {{\/presenting}}\n    <\/p>\n<\/div>"}
ace.define("ace/mode/sh",["require","exports","module","ace/lib/oop","ace/mode/text","ace/tokenizer","ace/mode/sh_highlight_rules","ace/range"],(function(e,t,n){var r=e("../lib/oop"),i=e("./text").Mode,o=e("../tokenizer").Tokenizer,s=e("./sh_highlight_rules").ShHighlightRules,a=e("../range").Range,l=function(){this.$tokenizer=new o((new s).getRules())};r.inherits(l,i),function(){this.toggleCommentLines=function(e,t,n,r){for(var i=!0,o=/^(\s*)#/,s=n;s<=r;s++)if(!o.test(t.getLine(s))){i=!1;break}if(i){var l=new a(0,0,0,0);for(s=n;s<=r;s++){var g=t.getLine(s).match(o);l.start.row=s,l.end.row=s,l.end.column=g[0].length,t.replace(l,g[1])}}else t.indentRows(n,r,"#")},this.getNextLineIndent=function(e,t,n){var r=this.$getIndent(t),i=this.$tokenizer.getLineTokens(t,e).tokens;if(i.length&&"comment"==i[i.length-1].type)return r;"start"==e&&(t.match(/^.*[\{\(\[\:]\s*$/)&&(r+=n));return r};var e={pass:1,return:1,raise:1,break:1,continue:1};this.checkOutdent=function(t,n,r){if("\r\n"!==r&&"\r"!==r&&"\n"!==r)return!1;var i=this.$tokenizer.getLineTokens(n.trim(),t).tokens;if(!i)return!1;do{var o=i.pop()}while(o&&("comment"==o.type||"text"==o.type&&o.value.match(/^\s+$/)));return!!o&&("keyword"==o.type&&e[o.value])},this.autoOutdent=function(e,t,n){n+=1;var r=this.$getIndent(t.getLine(n)),i=t.getTabString();r.slice(-i.length)==i&&t.remove(new a(n,r.length-i.length,n,r.length))}}.call(l.prototype),t.Mode=l})),ace.define("ace/mode/sh_highlight_rules",["require","exports","module","ace/lib/oop","ace/mode/text_highlight_rules"],(function(e,t,n){var r=e("../lib/oop"),i=e("./text_highlight_rules").TextHighlightRules,o=t.reservedKeywords="!|{|}|case|do|done|elif|else|esac|fi|for|if|in|then|until|while|&|;|export|local|read|typeset|unset|elif|select|set",s=t.languageConstructs="[|]|alias|bg|bind|break|builtin|cd|command|compgen|complete|continue|dirs|disown|echo|enable|eval|exec|exit|fc|fg|getopts|hash|help|history|jobs|kill|let|logout|popd|printf|pushd|pwd|return|set|shift|shopt|source|suspend|test|times|trap|type|ulimit|umask|unalias|wait",a=function(){var e=this.createKeywordMapper({keyword:o,"support.function.builtin":s,"invalid.deprecated":"debugger"},"identifier"),t="(?:\\d+)",n="(?:(?:"+t+"?(?:\\.\\d+))|(?:"+t+"\\.))",r="(?:"+("(?:(?:"+n+"|"+t+"))")+"|"+n+")",i="(?:&"+t+")",a="[a-zA-Z][a-zA-Z0-9_]*",l="(?:(?:\\$"+a+")|(?:"+a+"=))",g="(?:"+a+"\\s*\\(\\))";this.$rules={start:[{token:"comment",regex:"#.*$"},{token:"string",regex:'"(?:[^\\\\]|\\\\.)*?"'},{token:"variable.language",regex:"(?:\\$(?:SHLVL|\\$|\\!|\\?))"},{token:"variable",regex:l},{token:"support.function",regex:g},{token:"support.function",regex:i},{token:"string",regex:"'(?:[^\\\\]|\\\\.)*?'"},{token:"constant.numeric",regex:r},{token:"constant.numeric",regex:"(?:(?:[1-9]\\d*)|(?:0))\\b"},{token:e,regex:"[a-zA-Z_$][a-zA-Z0-9_$]*\\b"},{token:"keyword.operator",regex:"\\+|\\-|\\*|\\*\\*|\\/|\\/\\/|~|<|>|<=|=>|=|!="},{token:"paren.lparen",regex:"[\\[\\(\\{]"},{token:"paren.rparen",regex:"[\\]\\)\\}]"},{token:"text",regex:"\\s+"}]}};r.inherits(a,i),t.ShHighlightRules=a}));

Encoding.default_external = 'utf-8'
# css map for chrome
sourcemap = true
# 關閉圖片cache_burster
asset_cache_buster {|*args| nil }

# 合併sass資料夾內檔案
# require 'sass-globbing'

require 'compass/import-once/activate'
# Require any additional compass plugins here.

# Set this to the root of your project when deployed:
http_path = "../"
css_dir = "css"
sass_dir = "sass"
images_dir = "image"
javascripts_dir = "js"


#選擇CSS格式:   output_style意思則是指你的編譯出來的CSS碼要用哪種方式編譯出來。
##編譯共有下述四種方式：
##	:expanded		= 一般，每行CSS皆會斷行
##	:nested			= 有縮進，較好閱讀
##	:compact		= 簡潔格式，匯出來的ＣＳＳ檔案大小比上面兩個還小。
##	:compressed	    = 壓縮過的CSS，所有設定都以一行來進行排列。

output_style = :expanded

# You can select your preferred output style here (can be overridden via the command line):
# output_style = :expanded or :nested or :compact or :compressed

# To enable relative paths to assets via compass helper functions. Uncomment:
# relative_assets = true

# To disable debugging comments that display the original location of your selectors. Uncomment:
line_comments = false # 關閉註解


# If you prefer the indented syntax, you might want to regenerate this
# project again passing --syntax sass, or you can uncomment this:
# preferred_syntax = :sass
# and then run:
# sass-convert -R --from scss --to sass sass scss && rm -rf sass && mv scss sass

/**
 * gulpの使い方
 * コマンドを叩くときはこのファイルと同じ階層で叩いてね
 *
 * 1) 初めて叩くとき/PULLしたらエラーになったとき
 * $ npm install
 *  -> npmモジュールが追加されている可能性がある
 *
 * 2) CSSコンパイル & Sassの自動コンパイル
 * $ gulp   or $ gulp watch
 * 
 * 3) shashoku_collection へのCSSデプロイ
 * $ gulp deploy-css
 * ※ローカルファイルのsassをコンパイルしてアップするので注意
 * 
 * 4) テストフォルダへのサーバーデプロイ
 * $ gulp deploy --o morii // モリー用
 * $ gulp deploy --o tamiko // tami用
 * /dev/tamiko/.. に勝手にフォルダ作りましたがこちらにアップされる
 * 何かとテストしたいとき用にどうぞ!
 *
 * 基本、gulp.task('sass'.. のsassの部分がコマンドの第一引数になります。
 * ex) $ gulp sass で gulp.task('sass', function(){} が実行される
 *
 * 備考: このファイル機密事項いぱーいなのでパーミッションは最低ランク
 */

var gulp = require('gulp');
var dir = require('require-dir');
var git = require('gulp-git');
var minimist = require('minimist');
// コマンドラインの引数をパース
var args = minimist(process.argv.slice(2));
var conf = require('./config.json');
var path = args.o ? conf[args.o].path : null;

dir( './gulp/', { recurse: true } );

// css最適化
var sass = require('gulp-sass');
var minifyCss = require('gulp-minify-css');
var cssnext = require('gulp-cssnext');
var paths = {
  'sass':'./app/webroot/css/sass/',
  'css': './app/webroot/css/'
}
gulp.task('sass', function() {
  return gulp.src(paths.sass + 'style.sass')
    .pipe(sass())
    .on('error', function(err) {
      console.log(err.message);
    })
    .pipe(cssnext())
    .pipe(minifyCss())
    .pipe(gulp.dest(paths.css))
});
gulp.task('watch',['sass'], function() {
    gulp.watch(paths.sass + '*.sass', ['sass']);
});
gulp.task('default', ['watch']);

// デプロイ
var gutil = require('gulp-util');
var ftp = require('vinyl-ftp');
var conn_config = {
  host: 'users407.lolipop.jp',
  user: 'pupu.jp-shashoku-c',
  password: 'munagemojamoja1219',
  parallel: 5,
  log: gutil.log
}
var remoteDest = path;
var remoteDest_css = '/shashoku_collection/app/webroot/css';
var localDest_css = [
  'app/webroot/css/style.css'
];
var globs = [
  'app/**',
  '!app/tmp',
  '!app/tmp/**',
  '!app/Config/database.php'
];
var globs_all = [
  'app/**',
  '!app/tmp',
  '!app/tmp/**',
  '!app/Config/database.php'
];
gulp.task('deploy-css', ['sass'], function(){
  var conn = ftp.create(conn_config);
  return gulp.src(localDest_css, {buffer: false, dot: true})
    .pipe(conn.newerOrDifferentSize(remoteDest_css))
    .pipe(conn.dest(remoteDest_css));
});
gulp.task('deploy', ['sass'], function(){
  var conn = ftp.create(conn_config);
  if (path) {
    return gulp.src(globs_all, {buffer: false, dot: true})
      .pipe(conn.newerOrDifferentSize(remoteDest))
      .pipe(conn.dest(remoteDest));
  } else return;
});


/////////////////////////////////////////////////
// ここから▼サーバーが自由になったら使おうw
/////////////////////////////////////////////////
// Git Deploy
var deploy = require('gulp-deploy-git');
gulp.task('gitdeploy', function() {
  return gulp.src('./deploy')
    .pipe(deploy({
      repository: 'https://Tamii:xcdk5722@bitbucket.org/shashoku_collection/shashoku_collection.git',
      branches: ['develop/sprint2']
    }));
});
// git pull からの ftp アップ
gulp.task('git-deploy-ftp', function(){
  return gulp.src('./deploy')
    .pipe(git.clone('https://Tamii:xcdk5722@bitbucket.org/shashoku_collection/shashoku_collection.git', function (err) {
      if (err) throw err;
    }));
    // .pipe(git.pull('bitbucket', 'develop/sprint2', {args: '--rebase'}, function (err) {
    //   if (err) throw err;
    // }));
});
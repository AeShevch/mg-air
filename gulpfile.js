const gulp = require("gulp");
const sass = require("gulp-sass");
const autoprefixer = require("gulp-autoprefixer");
const cleanCSS = require("gulp-clean-css");
const sourcemaps = require("gulp-sourcemaps");
const plumber = require("gulp-plumber");
const babel = require("gulp-babel");
const uglify = require("gulp-uglify");
const rename = require("gulp-rename");
const concat = require("gulp-concat");
const rigger = require("gulp-rigger");

let changeDirToParent = function (file) {
  file.dirname = file.dirname.split("/").slice(0, -1).join("/");
};

let Path = {
  COMPONENTS: "components/**/src/",
  COMMON: "src/**/",
};

let componentsScss = function () {
  return gulp
    .src(Path.COMPONENTS + "*.scss")
    .pipe(sourcemaps.init())
    .pipe(plumber())
    .pipe(sass())
    .pipe(autoprefixer())
    .pipe(
      cleanCSS({
        level: {
          1: {
            specialComments: 0,
          },
        },
      })
    )
    .pipe(
      rename(function (file) {
        changeDirToParent(file);
      })
    )
    .pipe(sourcemaps.write(""))
    .pipe(gulp.dest((file) => file.base));
};

let commonScss = function () {
  return gulp
    .src(Path.COMMON + "main.scss")
    .pipe(sourcemaps.init())
    .pipe(plumber())
    .pipe(sass())
    .pipe(autoprefixer())
    .pipe(
      cleanCSS({
        level: {
          1: {
            specialComments: 0,
          },
        },
      })
    )
    .pipe(concat("style.css"))
    .pipe(sourcemaps.write(""))
    .pipe(gulp.dest("css"));
};

let componentsJs = function () {
  return gulp
    .src(Path.COMPONENTS + "*.js")
    .pipe(plumber())
    .pipe(babel())
    .pipe(
      rename(function (file) {
        changeDirToParent(file);
      })
    )
    .pipe(gulp.dest((file) => file.base));
};

let commonJs = function () {
  return (
    gulp
      .src(Path.COMMON + "*.js")
      .pipe(rigger())
      .pipe(plumber())
      .pipe(babel())
      // .pipe(uglify())
      .pipe(concat("bundle.js"))
      .pipe(gulp.dest("js"))
  );
};

gulp.task("componentsScss", componentsScss);
gulp.task("commonScss", commonScss);
gulp.task("componentsJs", componentsJs);
gulp.task("commonJs", commonJs);

let watch = function () {
  gulp.watch(Path.COMPONENTS + "*.scss", componentsScss);
  gulp.watch(Path.COMMON + "*.scss", commonScss);
  gulp.watch(Path.COMPONENTS + "*.js", componentsJs);
  gulp.watch(Path.COMMON + "*.js", commonJs);
};

gulp.task("watch", watch);

gulp.task(
  "build",
  gulp.series(gulp.parallel(componentsScss, commonScss, commonJs, componentsJs))
);

gulp.task("default", gulp.series("build", "watch"));

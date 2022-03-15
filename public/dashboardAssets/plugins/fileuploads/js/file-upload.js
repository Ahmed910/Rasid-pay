$(".dropify").dropify({
  messages: {
    default: "اسحب واسقط او قم برفع الصورة",
    replace: "اسحب واسقط او إضغط لتغغير الصورة",
    remove: "حذف",
    error: "اووه ، حدث خطأ ما",
  },
  error: {
    fileSize: "حجم الملف كبير (5M max).",
    minWidth: "The image width is too small ({{ value }}}px min).",
    maxWidth: "The image width is too big ({{ value }}}px max).",
    minHeight: "The image height is too small ({{ value }}}px min).",
    maxHeight: "The image height is too big ({{ value }}px max).",
    imageFormat: "The image format is not allowed ({{ value }} only).",
  },
  
});

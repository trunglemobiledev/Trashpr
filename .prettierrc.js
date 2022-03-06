module.exports = {
  overrides: [
    {
      files: '*.{js,vue}',
      options: {
        arrowParens: 'avoid',
        bracketSpacing: true,
        htmlWhitespaceSensitivity: 'ignore',
        insertPragma: false,
        jsxBracketSameLine: false,
        jsxSingleQuote: true,
        printWidth: 120,
        proseWrap: 'always',
        quoteProps: 'as-needed',
        requirePragma: false,
        semi: true,
        singleQuote: true,
        tabWidth: 2,
        trailingComma: 'es5',
        useTabs: false,
        vueIndentScriptAndStyle: false
      }
    },
    {
      files: '*.php',
      options: {
        printWidth: 200,
        tabWidth: 4,
        useTabs: false,
        semi: false,
        singleQuote: true,
        trailingCommaPHP: true,
      }
    }
  ]
};

export function SatellizerConfig ($authProvider) {
  'ngInject'

  $authProvider.httpInterceptor = function () {
    return true
  }

  $authProvider.loginUrl = '/auth/login'
  $authProvider.signupUrl = '/auth/register'
  $authProvider.tokenRoot = 'token' // compensates success response macro
}

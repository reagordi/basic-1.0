@echo off

rem -------------------------------------------------------------
rem  Reagordi command line bootstrap script for Windows.
rem
rem  @author Sergej Rufov <support@reagordi.com>
rem  @link https://reagordi.com/
rem  @copyright Copyright (c) 2020 Reagordi Software LLC
rem  @license https://reagordi.com/license/
rem -------------------------------------------------------------

@setlocal

set REAGORDI_PATH=%~dp0

if "%PHP_COMMAND%" == "" set PHP_COMMAND=php.exe

"%PHP_COMMAND%" "%YII_PATH%Reagordi" %*

@endlocal

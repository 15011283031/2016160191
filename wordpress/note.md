# ubuntu
## 1.ubuntu安装
### 1.1安装ubuntu系统
- 安装ubuntu系统，设定初始账户及密码，ubuntu,密码为随机码，例如CershiHjgEbenre5
- 第一次进入后进入到tyy1下，注意tyy1下不识别小键盘区，输入数字应该使用字母键区域
- **设定root账户密码,输入如下代码并且按照提示设定root账户新密码**
```
ubuntu@VM-38-190-ubuntu:~$ sudo passwd
Enter new UNIX password:
```
### 1.2更新ubuntu系统源
- 新安装的系统会默认为国外的源，由于墙的原因国外源无法使用，我们要替换成国内源才能够正常更新，我们选择的源是国内的阿里云的源mirrors.aliyun.com
1. 首先使用vi打开编辑源列表文件（初始化情况下默认不安装vim，也无图形界面可使用）,如果不放心建议先用cp命令进行备份,注意使用root账户
```
$su
$************
$vi /etc/apt/sources.list
```
2. 在vi编辑器下使用替换命令进行更新
```
:%s#/net.archive.ubuntu.com#/mirrors.aliyun.com#g
:w
:q
```
3. 更新源列表测试速度
```
$sudo apt-get update
```
### 1.3VIM使用
1	xshell中打开vim	vim 文件名
	例如：$ vim ./config.inc.php
2	vim编辑文件	i	
3	vim跳行	20j 向下跳20个字符
20k 向上调20个字符
20h 向左跳20个字符
20l 向右跳20个字符	注意不要在编辑状态下浏览
例如20j

序号|操作|命令|示例
---|---|---|---
1|xshell中打开vim|vim 文件名|例如：$ vim ./config.inc.php
2|vim编辑文件|i
3|vim跳行|20j 向下跳20个字符<br>20k 向上调20个字符<br>20h 向左跳20个字符<br>20l 向右跳20个字符<br>注意不要在编辑状态下浏览|例如20j




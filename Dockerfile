FROM  ubuntu:16.04
# 使用Ubuntu1604作为基础镜像
ENV TERM dumb
# 环境变量:shell
ENV DEBIAN_FRONTEND noninteractive
# 环境变量:unknown(必须保留，否则会出现bug)
WORKDIR /home/
# 定义以下语句执行位置:/home
EXPOSE 22 80 3306
# 开放端口 22 80 3306
COPY lnmp1.5.tar.gz /home/
# 复制完整安装包进入home目录
COPY sources.list /etc/apt/sources.list
# 使用中科大的镜像源文件替代原有镜像文件
COPY default.tar.gz /home/
# 复制网站根目录压缩包进入/home/文件夹
COPY screeninstall.sh /home/
# 复制主要安装脚本进入/home/文件夹,screeninstall使用expect执行first脚本
COPY first.sh /home/
# 复制first安装脚本进入/home/文件夹,first使用lnmp.org提供的一键安装包进行环境安装
COPY all.sql /home/
# 
COPY second.sh /home/
# 复制second脚本进入/home/文件夹,second更改网站根目录文件并更改数据库,并使用命令初始化数据库
RUN apt -y --force-yes update \
    && apt -y --force-yes upgrade \
    && apt -y --force-yes install tar wget expect curl \
    && chmod 777 /home/screeninstall.sh \
    && /home/screeninstall.sh
# 使用apt升级，安装tar,wget,expect,curl命令并赋予screeninstall脚本执行权限后执行该脚本
RUN ["/bin/bash","/home/second.sh"]
# 运行second脚本
RUN rm -rf /home/*.tar.gz \
    && rm -rf /home/*.sh \
    && rm -rf /home/*.sql \
    && rm -rf /home/lnmp* \
    && apt-get clean \
    && ls
COPY third.sh /home/
# 复制third脚本进入/home/文件夹,third为每次启动时启动mysql进程nginx进程php进程
ENTRYPOINT [ "/bin/bash","/home/third.sh" ]
# 启动后运行third脚本
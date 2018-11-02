# PandaMD
Editeur markdown permettant de téléchager un pdf (via pandoc)

# Installation
## Pandoc
```sh
wget https://github.com/jgm/pandoc/releases/download/2.3.1/pandoc-2.3.1-1-amd64.deb
sudo dpkg -i pandoc-2.3.1-1-amd64.deb
rm pandoc-2.3.1-1-amd64.deb
wget http://mirror.ctan.org/systems/texlive/tlnet/install-tl-unx.tar.gz
tar -xvzf install-tl-unx.tar.gz 
cd install-tl-20181101
sudo ./install-tl
export 'PATH=$PATH:/usr/local/texlive/2018/bin/x86_64-linux/' >> .bash_profile
```

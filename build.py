import os
import re
import sys
import shutil
import packer
from zipfile import *

sep=os.path.sep
debugpat=re.compile('console\.debug');
def makeMudimJs():
        p = packer.JavaScriptPacker()
        devfile=open('mudim'+sep+'mudim-dev.js')
        script = ''
        for line in devfile:
                if debugpat.search(line)==None:
                        script = script + line
        result=p.pack(script, compaction=True, encoding=62, fastDecode=True)
        shutil.copy('mudim'+sep+'BOM','mudim'+sep+'mudim.js')
        copyr=open('mudim'+sep+'COPYRIGHT','r')
        mudjs=open('mudim'+sep+'mudim.js','a')
        for line in copyr:
                mudjs.write(line)
        mudjs.write('\n')
        mudjs.write(result)
        cfg=open('mudim'+sep+'CONFIG','r')
        for line in cfg:
                mudjs.write(line)
        mudjs.write('\n')
        mudjs.close()
    
def makeMudimZip():
        mudzipNameList=['mudim'+sep+'index.html',\
                'mudim'+sep+'iframe.html',\
                'mudim'+sep+'test_init.js',\
                'mudim'+sep+'mudim.js']
        zf = ZipFile('mudim.zip','w',ZIP_DEFLATED)
        for fn in mudzipNameList:
                zf.write(fn,sep+fn)
        zf.close()

def makeMudimFfx():
        #create mudim.jar
        mudjarNameList=[['mudim-ffx'+sep+'chrome'+sep+'content'+sep+'contents.rdf',sep+'content'+sep+'contents.rdf'],\
                    ['mudim-ffx'+sep+'chrome'+sep+'content'+sep+'mudim.xul',sep+'content'+sep+'mudim.xul'],\
                    ['mudim-ffx'+sep+'chrome'+sep+'content'+sep+'mudim.js',sep+'content'+sep+'mudim.js'],\
                    ['mudim-ffx'+sep+'chrome'+sep+'skin'+sep+'contents.rdf',sep+'skin'+sep+'contents.rdf'],\
                    ['mudim-ffx'+sep+'chrome'+sep+'skin'+sep+'simple'+sep+'off.png',sep+'skin'+sep+'simple'+sep+'off.png'],\
                    ['mudim-ffx'+sep+'chrome'+sep+'skin'+sep+'simple'+sep+'vni.png',sep+'skin'+sep+'simple'+sep+'vni.png'],\
                    ['mudim-ffx'+sep+'chrome'+sep+'skin'+sep+'simple'+sep+'telex.png',sep+'skin'+sep+'simple'+sep+'telex.png'],\
                    ['mudim-ffx'+sep+'chrome'+sep+'skin'+sep+'simple'+sep+'viqr.png',sep+'skin'+sep+'simple'+sep+'viqr.png'],\
                                        ['mudim-ffx'+sep+'chrome'+sep+'skin'+sep+'simple'+sep+'auto.png',sep+'skin'+sep+'simple'+sep+'auto.png'],\
                    ['mudim-ffx'+sep+'chrome'+sep+'skin'+sep+'solid'+sep+'off.png',sep+'skin'+sep+'solid'+sep+'off.png'],\
                    ['mudim-ffx'+sep+'chrome'+sep+'skin'+sep+'solid'+sep+'vni.png',sep+'skin'+sep+'solid'+sep+'vni.png'],\
                    ['mudim-ffx'+sep+'chrome'+sep+'skin'+sep+'solid'+sep+'telex.png',sep+'skin'+sep+'solid'+sep+'telex.png'],\
                    ['mudim-ffx'+sep+'chrome'+sep+'skin'+sep+'solid'+sep+'viqr.png',sep+'skin'+sep+'solid'+sep+'viqr.png'],\
                                        ['mudim-ffx'+sep+'chrome'+sep+'skin'+sep+'solid'+sep+'auto.png',sep+'skin'+sep+'solid'+sep+'auto.png'],\
                    ['mudim-ffx'+sep+'chrome'+sep+'skin'+sep+'light'+sep+'off.png',sep+'skin'+sep+'light'+sep+'off.png'],\
                    ['mudim-ffx'+sep+'chrome'+sep+'skin'+sep+'light'+sep+'vni.png',sep+'skin'+sep+'light'+sep+'vni.png'],\
                    ['mudim-ffx'+sep+'chrome'+sep+'skin'+sep+'light'+sep+'telex.png',sep+'skin'+sep+'light'+sep+'telex.png'],\
                    ['mudim-ffx'+sep+'chrome'+sep+'skin'+sep+'light'+sep+'viqr.png',sep+'skin'+sep+'light'+sep+'viqr.png'],\
                                        ['mudim-ffx'+sep+'chrome'+sep+'skin'+sep+'light'+sep+'auto.png',sep+'skin'+sep+'light'+sep+'auto.png']]
        jsfile = open(mudjarNameList[2][0],'r')
        script=''
        for line in jsfile:
                if debugpat.search(line) == None:
                        script = script + line
        jsfile.close()
        jsfile = open(mudjarNameList[2][0],'w')
        jsfile.write(script)
        jsfile.close()
        #create jar file
        zf=ZipFile('mudim.jar','w',ZIP_STORED)
        for fentry in mudjarNameList:
                zf.write(fentry[0],fentry[1])
        zf.close()
        #create mudim.xpi
        zf=ZipFile('mudim-ffx'+sep+'mudim.xpi','w',ZIP_DEFLATED)
        zf.write('mudim-ffx'+sep+'install.rdf',sep+'install.rdf')
        zf.write('mudim-ffx'+sep+'chrome.manifest',sep+'chrome.manifest')
        zf.write('mudim.jar',sep+'chrome'+sep+'mudim.jar')
        zf.close()
        os.remove('mudim.jar')
        
def makeMudimWwp():
        mudWwpFileList=[['mudim-wwp'+sep+'mudim.php',sep+'mudim'+sep+'mudim.php'],\
                         ['mudim'+sep+'mudim.js',sep+'mudim'+sep+'mudim.js']]
        zf = ZipFile('mudim-wwp'+sep+'mudim-wwp.zip','w',ZIP_DEFLATED)
        for fn in mudWwpFileList:
                zf.write(fn[0],fn[1])
        zf.close()
        
def printUsage():
	print '''
Usage: 
	build.py [target1] [target2] [target3]
	
        Available target value:
                js: make mudim.js
                zip: make mudim.zip
                ffx: make mudim.xpi
                wwp: make mudim-wwp.zip
                all: make all
	'''
if __name__=='__main__':
	if len(sys.argv) > 1:
		for func in sys.argv[1:]:
			if func=='js':
				makeMudimJs()
			elif func=='zip':
				makeMudimJs()
				makeMudimZip()
			elif func=='ffx':
				makeMudimFfx()
			elif func=='wwp':
                                makeMudimWwp()
			elif func=='all':
			    makeMudimJs()
			    makeMudimZip()
			    makeMudimFfx()
			    makeMudimWwp()
			else:
				printUsage()				
	else:
		printUsage()
